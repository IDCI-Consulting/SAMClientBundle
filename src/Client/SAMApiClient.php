<?php

namespace IDCI\Bundle\SAMClientBundle\Client;

use IDCI\Bundle\SAMClientBundle\Model\BusinessDeal;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SAMApiClient
{
    public const MODE_STAGING = 'staging';
    public const MODE_LIVE = 'live';

    private HttpClientInterface $httpClient;
    private LoggerInterface $logger;
    private AdapterInterface $cache;
    private string $clientId;
    private string $clientSecret;
    private string $mode;

    public function __construct(
        HttpClientInterface $httpClient,
        LoggerInterface $logger,
        AdapterInterface $cache,
        string $clientId,
        string $clientSecret,
        string $mode
    ) {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->cache = $cache;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->mode = $mode;
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

    public function getApiBaseUrl(): string
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

        return self::MODE_LIVE === $this->mode ? 'https://sam.savinsight.com' : 'https://sam-staging.savinsight.com';
    }

    private function getAccessTokenCacheKey(): string
    {
        return 'idci_sam_client.access_token';
    }

    public function getAccessTokenResponse(): ?ResponseInterface
    {
        $response = null;

        try {
            $response = $this->httpClient->request('POST', $this->getAccessTokenUrl(), [
                'json' => [
                    'audience' => 'https://api.sam.savinsight.com',
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                ]
            ]);

            $response->getContent();
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

        $accessToken = json_decode($response->getContent(), true);

        $item = $this->cache->getItem($this->getAccessTokenCacheKey());
        $item->set($response->getContent());
        $item->expiresAfter($accessToken['expires_in']);
        $this->cache->save($item);

        return $accessToken;
    }

    public function createActivity(string $id, string $activityCode, array $options)
    {
        // POST /api/BusinessDeals/{id}/activities/{activityCode}
    }

    public function updateActivity(string $id, string $activityCode, array $options)
    {
        // PUT /api/BusinessDeals/{id}/activities/{activityCode}
    }

    public function createActivityByInternalNumber(string $internalNumber, string $activityCode, array $options)
    {
        // POST /api/BusinessDeals/ByInternalNumber/{internalNumber}/activities/{activityCode}
    }

    public function updateActivityByInternalNumber(string $internalNumber, string $activityCode, array $options)
    {
        // PUT /api/BusinessDeals/ByInternalNumber/{internalNumber}/activities/{activityCode}
    }

    public function createActivityByExternalId(string $externalId, string $activityCode, array $options)
    {
        // POST /api/BusinessDeals/ByExternalId/{externalId}/activities/{activityCode}
    }

    public function updateActivityByExternalId(string $externalId, string $activityCode, array $options)
    {
        // PUT /api/BusinessDeals/ByExternalId/{externalId}/activities/{activityCode}
    }

    public function createDiagnostics(string $id, array $options)
    {
        // POST /api/BusinessDeals/{id}/diagnostics
    }

    public function createDiagnosticsByInternalNumber(string $internalNumber, array $options)
    {
        // POST /api/BusinessDeals/ByInternalNumber/{internalNumber}/diagnostics
    }

    public function createDiagnosticsByExternalId(string $externalId, array $options)
    {
        // POST /api/BusinessDeals/ByExternalId/{externalId}/diagnostics
    }

    public function createBusinessDeal(array $options)
    {
        // POST /api/BusinessDeals/ByExternalId/{externalId}/diagnostics
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
            $response = $this->httpClient->request('GET', sprintf('%s/api/BusinessDeals/%s', $this->getApiBaseUrl(), $id), [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->getAccessToken()['access_token'])
                ],
            ]);

            $response->getContent();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return null;
        }

        return $this->createModelFromData(BusinessDeal::class, $response->toArray());
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
            $property->setAccessible(true);
            $property->setValue($modelObject, $value);
        }

        return $modelObject;
    }
}