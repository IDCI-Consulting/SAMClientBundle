<?php

namespace IDCI\Bundle\SAMClientBundle\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use IDCI\Bundle\SAMClientBundle\Model\ActivityUpdatedApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealApi;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealPayload;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealProgress;
use IDCI\Bundle\SAMClientBundle\Model\BusinessDealsUpdatedSinceApi;
use IDCI\Bundle\SAMClientBundle\Model\CreateDiagnosticInputWatchState;
use IDCI\Bundle\SAMClientBundle\Model\Enum\CreateDiagnosticInputWatchStateProductState;
use IDCI\Bundle\SAMClientBundle\Model\Enum\JsonPatchDocumentOperation;
use IDCI\Bundle\SAMClientBundle\Model\Enum\UpdateActivityInputStatus;
use IDCI\Bundle\SAMClientBundle\Model\JsonPatchDocument;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\SerializerInterface;

class SAMApiClient
{
    public const MODE_STAGING = 'staging';
    public const MODE_LIVE = 'live';

    private LoggerInterface $logger;
    private AdapterInterface $cache;
    private SerializerInterface $serializer;
    private ?ClientInterface $httpClient = null;
    private string $clientId;
    private string $clientSecret;
    private string $mode;

    public function __construct(
        LoggerInterface $logger,
        AdapterInterface $cache,
        SerializerInterface $serializer,
        string $clientId,
        string $clientSecret,
        string $mode
    ) {
        $this->logger = $logger;
        $this->cache = $cache;
        $this->serializer = $serializer;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->mode = $mode;
    }

    public function setHttpClient(ClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    public function setCache(AdapterInterface $cache): void
    {
        $this->cache = $cache;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
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
            $response = $this->httpClient->request('POST', $this->getAccessTokenUrl(), [
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
            ->setDefined('date')->setAllowedTypes('date', ['string', \DateTimeInterface::class, 'null'])
                ->setNormalizer('date', function (Options $options, $value) {
                    if ($value instanceof \DateTimeInterface) {
                        return $value->format('Y-m-d\TH:i:s.v\Z');
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
            $response = $this->httpClient->request('POST', sprintf('BusinessDeals/%s/activities/%s', $id, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), ActivityUpdatedApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);
        }

        return null;
    }

    public function createActivityByInternalNumber(string $internalNumber, string $activityCode, array $options): ?ActivityUpdatedApi
    {
        $resolver = new OptionsResolver();
        $this->configureStartActivityInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('POST', sprintf('BusinessDeals/ByInternalNumber/%s/activities/%s', $internalNumber, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), ActivityUpdatedApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);
        }

        return null;
    }

    public function createActivityByExternalId(string $externalId, string $activityCode, array $options): ?ActivityUpdatedApi
    {
        $resolver = new OptionsResolver();
        $this->configureStartActivityInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('POST', sprintf('BusinessDeals/ByExternalId/%s/activities/%s', $externalId, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), ActivityUpdatedApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);
        }

        return null;
    }

    public function configureUpdateActivityInput(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined('status')->setAllowedTypes('status', [UpdateActivityInputStatus::class])
            ->setDefined('employeeCode')->setAllowedTypes('employeeCode', ['string', 'null'])
            ->setDefined('date')->setAllowedTypes('date', ['string', \DateTimeInterface::class, 'null'])
                ->setNormalizer('date', function (Options $options, $value) {
                    if ($value instanceof \DateTimeInterface) {
                        return $value->format('Y-m-d\TH:i:s.v\Z');
                    }

                    return $value;
                })
        ;
    }

    public function updateActivity(string $id, string $activityCode, array $options): ?ActivityUpdatedApi
    {
        $resolver = new OptionsResolver();
        $this->configureUpdateActivityInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('PUT', sprintf('BusinessDeals/%s/activities/%s', $id, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), ActivityUpdatedApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);
        }

        return null;
    }

    public function updateActivityByInternalNumber(string $internalNumber, string $activityCode, array $options): ?ActivityUpdatedApi
    {
        $resolver = new OptionsResolver();
        $this->configureUpdateActivityInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('PUT', sprintf('BusinessDeals/ByInternalNumber/%s/activities/%s', $internalNumber, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), ActivityUpdatedApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);
        }

        return null;
    }

    public function updateActivityByExternalId(string $externalId, string $activityCode, array $options): ?ActivityUpdatedApi
    {
        $resolver = new OptionsResolver();
        $this->configureUpdateActivityInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('PUT', sprintf('BusinessDeals/ByExternalId/%s/activities/%s', $externalId, $activityCode), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), ActivityUpdatedApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);
        }

        return null;
    }

    public function configureCreateDiagnosticInput(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined('date')->setAllowedTypes('date', ['string', \DateTimeInterface::class, 'null'])
                ->setNormalizer('date', function (Options $options, $value) {
                    if ($value instanceof \DateTimeInterface) {
                        return $value->format('Y-m-d');
                    }

                    return $value;
                })
            ->setDefined('watchStates')->setAllowedTypes('watchStates', ['array', 'null'])
                ->setNormalizer('watchStates', function (Options $options, $watchStates) {
                    $watchStatesResolver = (new OptionsResolver())
                        ->setRequired('toPrint')->setAllowedTypes('toPrint', ['bool'])
                        ->setRequired('materialReference')->setAllowedTypes('materialReference', ['string'])
                        ->setRequired('productState')->setAllowedTypes('productState', [CreateDiagnosticInputWatchStateProductState::class])
                        ->setDefined('internalComment')->setAllowedTypes('internalComment', ['string'])
                    ;

                    foreach ($watchStates as $watchState) {
                        if ($watchState instanceof CreateDiagnosticInputWatchState) {
                            $watchState = json_decode($this->serializer->serialize($watchState, 'json'), true);
                        }

                        $watchState = $watchStatesResolver->resolve($watchState);
                    }

                    return $watchStates;
                })
            ->setDefined('operations')->setAllowedTypes('operations', ['array', 'null'])
        ;
    }

    public function createDiagnostic(string $id, array $options): ?BusinessDealApi
    {
        $resolver = new OptionsResolver();
        $this->configureCreateDiagnosticInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('POST', sprintf('BusinessDeals/%s/diagnostics', $id), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), BusinessDealApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);
        }

        return null;
    }

    public function createDiagnosticByInternalNumber(string $internalNumber, array $options): ?BusinessDealApi
    {
        $resolver = new OptionsResolver();
        $this->configureCreateDiagnosticInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('POST', sprintf('BusinessDeals/ByInternalNumber/%s/diagnostics', $internalNumber), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), BusinessDealApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);
        }

        return null;
    }

    public function createDiagnosticByExternalId(string $externalId, array $options): ?BusinessDealApi
    {
        $resolver = new OptionsResolver();
        $this->configureCreateDiagnosticInput($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('POST', sprintf('BusinessDeals/ByExternalId/%s/diagnostics', $externalId), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), BusinessDealApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);
        }

        return null;
    }

    public function configureCreateBusinessDeal(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('externalId')->setAllowedTypes('externalId', ['string'])
                ->setNormalizer('externalId', function (Options $options, $externalId) {
                    if (empty($externalId)) {
                        throw new InvalidOptionsException('externalId must not be empty');
                    }

                    return $externalId;
                })
            ->setRequired('partnerReference')->setAllowedTypes('partnerReference', ['string'])
                ->setNormalizer('partnerReference', function (Options $options, $partnerReference) {
                    if (empty($partnerReference)) {
                        throw new InvalidOptionsException('partnerReference must not be empty');
                    }

                    return $partnerReference;
                })
            ->setRequired('brandReference')->setAllowedTypes('brandReference', ['string'])
                ->setNormalizer('brandReference', function (Options $options, $brandReference) {
                    if (empty($brandReference)) {
                        throw new InvalidOptionsException('brandReference must not be empty');
                    }

                    return $brandReference;
                })
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
                ->setNormalizer('progress', function (Options $options, $value) {
                    if ($value instanceof BusinessDealProgress) {
                        $value = json_decode($this->serializer->serialize($value, 'json'), true);
                    }

                    return $value;
                })
            ->setDefined('accessCode')->setAllowedTypes('accessCode', ['string', 'null'])
            ->setDefined('quickService')->setAllowedTypes('quickService', ['bool', 'null'])
            ->setDefined('interventionInvoicingCode')->setAllowedTypes('interventionInvoicingCode', ['string', 'null'])
        ;
    }

    public function createBusinessDeal(array $options): ?BusinessDealPayload
    {
        $resolver = new OptionsResolver();
        $this->configureCreateBusinessDeal($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('POST', 'BusinessDeals', [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), BusinessDealPayload::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions);
        }

        return null;
    }

    public function importBusinessDeal(string $importDataTemplateId): null
    {
        try {
            $response = $this->httpClient->request('PUT', sprintf('BusinessDeals/csv/%s', $importDataTemplateId), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                ],
            ]);
        } catch (RequestException $e) {
            $this->logRequestException($e);
        }

        return null;
    }

    public function deleteBusinessDeal(string $id): null
    {
        try {
            $response = $this->httpClient->request('DELETE', sprintf('BusinessDeals/%s', $id), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                ],
            ]);
        } catch (RequestException $e) {
            $this->logRequestException($e);
        }

        return null;
    }

    public function deleteBusinessDealByInternalNumber(string $internalNumber): null
    {
        try {
            $response = $this->httpClient->request('DELETE', sprintf('BusinessDeals/ByInternalNumber/%s', $internalNumber), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                ],
            ]);
        } catch (RequestException $e) {
            $this->logRequestException($e);
        }

        return null;
    }

    public function deleteBusinessDealByExternalId(string $externalId): null
    {
        try {
            $response = $this->httpClient->request('DELETE', sprintf('BusinessDeals/ByExternalId/%s', $externalId), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                ],
            ]);
        } catch (RequestException $e) {
            $this->logRequestException($e);
        }

        return null;
    }

    public function getBusinessDeal(string $id): ?BusinessDealApi
    {
        try {
            $response = $this->httpClient->request('GET', sprintf('BusinessDeals/%s', $id), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                ],
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), BusinessDealApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e);
        }

        return null;
    }

    public function getBusinessDealByInternalNumber(string $internalNumber): ?BusinessDealApi
    {
        try {
            $response = $this->httpClient->request('GET', sprintf('BusinessDeals/ByInternalNumber/%s', $internalNumber), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                ],
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), BusinessDealApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e);
        }

        return null;
    }

    public function getBusinessDealByExternalId(string $externalId): ?BusinessDealApi
    {
        try {
            $response = $this->httpClient->request('GET', sprintf('BusinessDeals/ByExternalId/%s', $externalId), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                ],
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), BusinessDealApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e);
        }

        return null;
    }

    public function getBusinessDealModifiedSince(\DateTimeInterface|string $modifiedSince): ?BusinessDealsUpdatedSinceApi
    {
        if ($modifiedSince instanceof \DateTimeInterface) {
            $modifiedSince = $modifiedSince->format('Y-m-d');
        }

        try {
            $response = $this->httpClient->request('GET', sprintf('BusinessDeals/ModifiedSince/%s', $modifiedSince), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                ],
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), BusinessDealsUpdatedSinceApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e);
        }

        return null;
    }

    public function configureJsonPatchDocuments(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined('jsonPatchDocuments')->setAllowedTypes('jsonPatchDocuments', ['array'])
                ->setNormalizer('jsonPatchDocuments', function (Options $options, $jsonPatchDocuments): array {
                    $jsonPatchDocumentResolver = (new OptionsResolver())
                        ->setDefined('op')->setAllowedTypes('op', [JsonPatchDocumentOperation::class])
                        ->setDefined('path')->setAllowedTypes('path', ['string', 'null'])
                        ->setDefined('value')
                            ->setNormalizer('value', function (Options $options, $value) {
                                if (is_object($value)) {
                                    $value = json_decode($this->serializer->serialize($value, 'json'), true);
                                }

                                return $value;
                            })
                        ->setDefined('from')->setAllowedTypes('from', ['string', 'null'])
                    ;

                    foreach ($jsonPatchDocuments as $jsonPatchDocument) {
                        if ($jsonPatchDocument instanceof JsonPatchDocument) {
                            $jsonPatchDocument = json_decode($this->serializer->serialize($jsonPatchDocument, 'json'), true);
                        }

                        $jsonPatchDocument = $jsonPatchDocumentResolver->resolve($jsonPatchDocument);
                    }

                    return $jsonPatchDocuments;
                })
        ;
    }

    public function updateBusinessDeal(string $id, array $options): ?BusinessDealApi
    {
        $resolver = new OptionsResolver();
        $this->configureJsonPatchDocuments($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('PATCH', sprintf('BusinessDeals/%s', $id), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions['jsonPatchDocuments']),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), BusinessDealApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions['jsonPatchDocuments']);
        }

        return null;
    }

    public function updateBusinessDealByInternalNumber(string $internalNumber, array $options): ?BusinessDealApi
    {
        $resolver = new OptionsResolver();
        $this->configureJsonPatchDocuments($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('PATCH', sprintf('BusinessDeals/ByInternalNumber/%s', $internalNumber), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions['jsonPatchDocuments']),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), BusinessDealApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions['jsonPatchDocuments']);
        }

        return null;
    }

    public function updateBusinessDealByExternalId(string $externalId, array $options): ?BusinessDealApi
    {
        $resolver = new OptionsResolver();
        $this->configureJsonPatchDocuments($resolver);
        $resolvedOptions = $resolver->resolve($options);

        try {
            $response = $this->httpClient->request('PATCH', sprintf('BusinessDeals/ByExternalId/%s', $externalId), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token']),
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($resolvedOptions['jsonPatchDocuments']),
            ]);

            return $this->serializer->deserialize((string) $response->getBody(), BusinessDealApi::class, 'json');
        } catch (RequestException $e) {
            $this->logRequestException($e, $resolvedOptions['jsonPatchDocuments']);
        }

        return null;
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
