<?php

namespace IDCI\Bundle\SAMClientBundle\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDeal;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealPayload;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealProgress;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SAMApiClient
{
    public const MODE_STAGING = 'staging';
    public const MODE_LIVE = 'live';

    private LoggerInterface $logger;
    private AdapterInterface $cache;
    private ?ClientInterface $samApiClient = null;
    private string $clientId;
    private string $clientSecret;
    private string $mode;

    public function __construct(
        LoggerInterface $logger,
        AdapterInterface $cache,
        string $clientId,
        string $clientSecret,
        string $mode
    ) {
        $this->logger = $logger;
        $this->cache = $cache;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->mode = $mode;
    }

    public function setHttpClient(ClientInterface $samApiClient)
    {
        $this->samApiClient = $samApiClient;
    }

    public function getAccessTokenUrl(): string
    {
        if (!in_array($this->mode, [self::MODE_LIVE, self::MODE_STAGING])) {
            $this->logger->warning(
                sprintf(
                    'The mode "%s" is not supported, allowed values: %s. Fallback to staging mode.',
                    $this->mode,
                    join(', ', [self::MODE_LIVE, self::MODE_STAGING])
                )
            );
        }

        return self::MODE_LIVE === $this->mode ? 'https://savinsight.eu.auth0.com/oauth/token' : 'https://savinsight-staging.eu.auth0.com/oauth/token';
    }

    private function getAccessTokenCacheKey(): string
    {
        return 'idci_sam_client.access_token';
    }

    public function getAccessTokenResponse(): ?Response
    {
        $response = null;

        try {
            $response = $this->samApiClient->post($this->getAccessTokenUrl(), [
                'json' => [
                    'audience' => 'https://api.sam.savinsight.com',
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                ],
            ]);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $response;
    }

    public function getAccessToken(): array
    {
        if ($this->cache->hasItem($this->getAccessTokenCacheKey())) {
            $accessToken = $this->cache->getItem($this->getAccessTokenCacheKey())->get();

            return json_decode($accessToken, true);
        }

        $response = $this->getAccessTokenResponse();

        if (null === $response) {
            throw new \Exception('Could not retrieve access token');
        }

        $accessToken = json_decode((string) $response->getBody(), true);

        $item = $this->cache->getItem($this->getAccessTokenCacheKey());
        $item->set((string) $response->getBody());
        $item->expiresAfter($accessToken['expires_in']);
        $this->cache->save($item);

        return $accessToken;
    }

    public function configureStartActivityInput(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined('employeeCode')->setAllowedTypes('employeeCode', ['string', 'null'])
            ->setDefined('date')->setAllowedTypes('date', ['string', \DateTime::class, 'null'])->setNormalizer('date', function (Options $options, $value) {
                if ($value instanceof \DateTime) {
                    return $value->format('Y-m-d H:i:s.v');
                }

                return $value;
            })
        ;
    }

    public function createActivity(int $id, string $activityCode, array $options): ?ActivityUpdatedApi
    {
        $resolver = new OptionsResolver();
        $this->configureStartActivityInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->samApiClient->post(sprintf('BusinessDeals/%s/activities/%s', $id, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->createModelFromData(ActivityUpdatedApi::class, json_decode((string) $response->getBody(), true));
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);
        }

        return null;
    }

    public function configureUpdateActivityInput(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined('status')->setAllowedValues('status', ['paused', 'started', 'terminated'])
            ->setDefined('employeeCode')->setAllowedTypes('employeeCode', ['string', 'null'])
            ->setDefined('date')->setAllowedTypes('date', ['string', \DateTimeInterface::class, 'null'])->setNormalizer('date', function (Options $options, $value) {
                if ($value instanceof \DateTimeInterface) {
                    return $value->format('Y-m-d H:i:s.v');
                }

                return $value;
            })
        ;
    }

    public function updateActivity(string $id, string $activityCode, array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureUpdateActivityInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->samApiClient->put(sprintf('BusinessDeals/%s/activities/%s', $id, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->createModelFromData(ActivityUpdatedApi::class, json_decode((string) $response->getBody(), true));
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);

            return null;
        }
    }

    public function createActivityByInternalNumber(string $internalNumber, string $activityCode, array $options): ?BusinessDealPayload
    {
        $resolver = new OptionsResolver();
        $this->configureStartActivityInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->samApiClient->post(sprintf('BusinessDeals/ByInternalNumber/%s/activities/%s', $internalNumber, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->createModelFromData(ActivityUpdatedApi::class, json_decode((string) $response->getBody(), true));
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);

            return null;
        }
    }

    public function updateActivityByInternalNumber(string $internalNumber, string $activityCode, array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureUpdateActivityInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->samApiClient->put(sprintf('BusinessDeals/ByInternalNumber/%s/activities/%s', $internalNumber, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->createModelFromData(ActivityUpdatedApi::class, json_decode((string) $response->getBody(), true));
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);

            return null;
        }
    }

    public function createActivityByExternalId(string $externalId, string $activityCode, array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureStartActivityInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->samApiClient->post(sprintf('BusinessDeals/ByExternalId/%s/activities/%s', $externalId, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->createModelFromData(ActivityUpdatedApi::class, json_decode((string) $response->getBody(), true));
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);

            return null;
        }
    }

    public function updateActivityByExternalId(string $externalId, string $activityCode, array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureUpdateActivityInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->samApiClient->put(sprintf('BusinessDeals/ByExternalId/%s/activities/%s', $externalId, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->createModelFromData(ActivityUpdatedApi::class, json_decode((string) $response->getBody(), true));
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);

            return null;
        }
    }

    public function configureCreateDiagnosticInput(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined('date')->setAllowedTypes('date', ['string', \DateTimeInterface::class, 'null'])->setNormalizer('date', function (Options $options, $value) {
                if ($value instanceof \DateTimeInterface) {
                    return $value->format('Y-m-d H:i:s.v');
                }

                return $value;
            })
            ->setDefined('watchStates')->setAllowedTypes('watchStates', ['array', 'null'])
            ->setDefined('operations')->setAllowedTypes('operations', ['array', 'null'])
        ;
    }

    public function createDiagnostics(string $id, array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureCreateDiagnosticInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->samApiClient->post(sprintf('BusinessDeals/%s/diagnotics', $id), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->createModelFromData(ActivityUpdatedApi::class, json_decode((string) $response->getBody(), true));
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);

            return null;
        }
    }

    public function configureCreateDiagnosticsByInternalNumber(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined('date')->setAllowedTypes('date', ['string', \DateTime::class, 'null'])->setNormalizer('date', function (Options $options, $value) {
                if ($value instanceof \DateTime) {
                    return $value->format('Y-m-d H:i:s.v');
                }

                return $value;
            })
            ->setDefined('watchStates')->setAllowedTypes('watchStates', ['array', 'null'])
            ->setDefined('operations')->setAllowedTypes('operations', ['array', 'null'])
        ;
    }

    public function createDiagnosticsByInternalNumber(string $internalNumber, array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureCreateActivity($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->samApiClient->post(sprintf('BusinessDeals/ByInternalNumber/%s/diagnotics', $internalNumber), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $response;
        } catch (RequestException $e) {
            $this->logger->error(null != $e->getResponse() ? (string) $e->getResponse()->getBody() : $e->getMessage());

            return null;
        }
    }

    public function configureCreateDiagnosticsByExternalId(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined('date')->setAllowedTypes('date', ['string', \DateTime::class, 'null'])->setNormalizer('date', function (Options $options, $value) {
                if ($value instanceof \DateTime) {
                    return $value->format('Y-m-d H:i:s.v');
                }

                return $value;
            })
            ->setDefined('watchStates')->setAllowedTypes('watchStates', ['array', 'null'])
            ->setDefined('operations')->setAllowedTypes('operations', ['array', 'null'])
        ;
    }

    public function createDiagnosticsByExternalId(string $externalId, array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureCreateActivity($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->samApiClient->post(sprintf('BusinessDeals/ByExternalId/%s/diagnotics', $externalId), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $response;
        } catch (RequestException $e) {
            $this->logger->error(null != $e->getResponse() ? (string) $e->getResponse()->getBody() : $e->getMessage());

            return null;
        }
    }

    public function configureCreateBusinessDeal(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('externalId')->setAllowedTypes('externalId', ['string'])
            ->setRequired('partnerReference')->setAllowedTypes('partnerReference', ['string'])
            ->setRequired('brandReference')->setAllowedTypes('brandReference', ['string'])
            ->setDefined('partnerSiteReference')->setAllowedTypes('partnerSiteReference', ['string', 'null'])
            ->setDefined('initialRequestorPartnerSiteReference')->setAllowedTypes('initialRequestorPartnerSiteReference', ['string', 'null'])
            ->setDefined('initialRequestorPartnerReference')->setAllowedTypes('initialRequestorPartnerReference', ['string', 'null'])
            ->setDefined('invoicingCode')->setAllowedTypes('invoicingCode', ['string', 'null'])
            ->setDefined('internalNumber')->setAllowedTypes('internalNumber', ['string', 'null'])
            ->setDefined('productNature')->setAllowedTypes('productNature', ['string', 'null'])
            ->setDefined('productReference')->setAllowedTypes('productReference', ['string', 'null'])
            ->setDefined('productSerialNumber')->setAllowedTypes('productSerialNumber', ['string', 'null'])
            ->setDefined('externalNumber')->setAllowedTypes('externalNumber', ['string', 'null'])
            ->setDefined('batchReference')->setAllowedTypes('batchReference', ['string', 'null'])
            ->setDefined('movementSerialNumberReference')->setAllowedTypes('movementSerialNumberReference', ['string', 'null'])
            ->setDefined('movementReference')->setAllowedTypes('movementReference', ['string', 'null'])
            ->setDefined('interventionCode')->setAllowedTypes('interventionCode', ['string', 'null'])
            ->setDefined('progress')->setAllowedTypes('progress', [BusinessDealProgress::class, 'array'])
            ->setDefined('accessCode')->setAllowedTypes('accessCode', ['string', 'null'])
        ;
    }

    public function createBusinessDeal(array $options): ?BusinessDealPayload
    {
        $resolver = new OptionsResolver();
        $this->configureCreateBusinessDeal($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->samApiClient->post('BusinessDeals', [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->createModelFromData(BusinessDealPayload::class, json_decode((string) $response->getBody(), true));
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);

            return null;
        }
    }

    public function importBusinessDeal(string $importDataTemplateId)
    {
        // PUT /api/BusinessDeals/ByExternalId/{externalId}/diagnostics
    }

    public function deleteBusinessDeal(string $id)
    {
        // DELETE /api/BusinessDeals/{id}
    }

    public function getBusinessDeal(string $id): ?BusinessDeal
    {
        $response = null;

        try {
            $response = $this->samApiClient->get(sprintf('BusinessDeals/%s', $id), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                ]
            ]);
        } catch (RequestException $e) {
            $this->logger->error(null != $e->getResponse() ? (string) $e->getResponse()->getBody() : $e->getMessage());

            return null;
        }

        dd(json_decode((string) $response->getBody(), true));

        return $this->createModelFromData(BusinessDealApi::class, json_decode((string) $response->getBody(), true));
    }

    public function updateBusinessDeal(string $id, array $options)
    {
        // PATCH /api/BusinessDeals/{id}
    }

    public function deleteBusinessDealByInternalNumber(string $internalNumber)
    {
        // DELETE /api/BusinessDeals/{id}
    }

    public function getBusinessDealByInternalNumber(string $internalNumber)
    {
        // GET /api/BusinessDeals/ByInternalNumber/{internalNumber}
    }

    public function updateBusinessDealByInternalNumber(string $internalNumber, array $options)
    {
        // PATCH /api/BusinessDeals/ByInternalNumber/{internalNumber}
    }

    public function deleteBusinessDealByExternalId(string $externalId)
    {
        // DELETE /api/BusinessDeals/ByExternalId/{externalId}
    }

    public function getBusinessDealByExternalId(string $externalId)
    {
        // GET /api/BusinessDeals/ByExternalId/{externalId}
    }

    public function updateBusinessDealByExternalId(string $externalId, array $options)
    {
        // PATCH /api/BusinessDeals/ByExternalId/{externalId}
    }

    public function getBusinessDealModifiedSince(\DateTimeInterface $modifiedSince)
    {
        // GET /api/BusinessDeals/ModifiedSince/{modifiedSinceDateTime}
    }

    private function createModelFromData(string $modelClass, array $data)
    {
        $reflectionClass = new \ReflectionClass($modelClass);
        $modelObject = $reflectionClass->newInstance();

        foreach ($data as $attribute => $value) {
            if (!$reflectionClass->hasProperty($attribute)) {
                $this->logger->warning(sprintf('The attribute "%s" is not mapped on the model class "%s"', $attribute, $modelClass));

                continue;
            }

            $property = $reflectionClass->getProperty($attribute);
            // verifier la class, si non objet : rien, sinon rappeler la methode
            $property->setAccessible(true);
            $property->setValue($modelObject, $value);
        }

        return $modelObject;
    }

    private function logRequestException(RequestException $e, array $options = []): void
    {
        $this->logger->error(
            sprintf(
                'method : %s, url : %s, status : %s, data : %s, message : %s',
                $e->getRequest()->getMethod(),
                $e->getRequest()->getUri(),
                null != $e->getResponse() ? (string) $e->getResponse()->getStatusCode() : null,
                json_encode($options),
                null != $e->getResponse() ? (string) $e->getResponse()->getBody() : $e->getMessage()
            )
        );
    }
}
