# IDCI SAM Client Bundle

Symfony bundle that provides an api client for SAM app (SAVInsight)

## Installation

Install this bundle using composer :

```sh
composer require idci/sam-client-bundle
```

## Configuration

### Create an Eightpoint Guzzle HTTP client

In the file `config/packages/eight_points_guzzle.yaml`, create a **SAM API** client :

```yaml
eight_points_guzzle:
    clients:
        sam_api:
            base_url: 'https://sam-staging.savinsight.com/api/' # PROD = 'https://sam.savinsight.com/api/'
```

### Configure a cache pool

Create a dedicated **SAM** cache, or use any of your existing pools :

In the file `config/services.yaml`, register your cache pool :

```yaml
# Redis example
app.cache.adapter.redis.sam:
    parent: 'cache.adapter.redis'
    tags:
        - { name: 'cache.pool', namespace: 'SAM' }
```

In the file `config/packages/cache.yaml`, define your cache pool :

```yaml
framework:
    cache:
        # ...
        pools:
            cache.sam:
                public: true
```

### Configure sam-client-bundle

In `config/packages/`, create a `idci_sam_client.yaml` file :

```yaml
idci_sam_client:
    guzzle_http_client_service_alias: 'eight_points_guzzle.client.sam_api'
    cache_pool_service_alias: 'cache.sam'
    client_id: '%env(string:IDCI_SAM_CLIENT_ID)%'
    client_secret: '%env(string:IDCI_SAM_CLIENT_SECRET)%'
    mode: '%env(string:IDCI_SAM_MODE)%'
```

Required parameters:
* **guzzle_http_client_service_alias** : The guzzle HTTP client alias
* **client_id** : The SAM client ID
* **client_secret** : The SAM client secret
* **mode**: `live` or `staging`

Then, add these environment variable in your `.env` file :

```
###> idci/sam-client-bundle ###
IDCI_SAM_CLIENT_ID=Y2xpZW50X2lk...
IDCI_SAM_CLIENT_SECRET=Y2xpZW50X3NlY3JldA==...
IDCI_SAM_MODE=live
###< idci/sam-client-bundle ###
```

To retrieve more informations about SAM API, go to [https://sam-staging.savinsight.com/swagger/index.html](https://sam-staging.savinsight.com/swagger/index.html).

## Usage

### Activity methods

#### Create activity

```php
use IDCI\Bundle\SAMClientBundle\Client\SAMApiClient;
...
$this->samApiClient->createActivity(20000, [
    'date' => new \DateTime,
    'employeeCode' => 'JeanDupont',
]);

$this->samApiClient->createActivityByInternalNumber('internalNumber', [
    'date' => new \DateTime,
    'employeeCode' => 'JeanDupont',
]);

$this->samApiClient->createActivityByExternalId('externalId', [
    'date' => new \DateTime,
    'employeeCode' => 'JeanDupont',
]);
```

| option name     | type                            |
|-----------------|---------------------------------|
| date            | DateTimeInterface, string, null |
| employeeCode    | string, null                    |

#### Update activity

```php
use IDCI\Bundle\SAMClientBundle\Client\SAMApiClient;
use IDCI\Bundle\SAMClientBundle\Client\Model\Enum\UpdateActivityInputState;
...
$this->samApiClient->updateActivity(20000, 'A020', [
    'status' => UpdateActivityInputState::Paused,
    'date' => new \DateTime,
    'employeeCode' => 'JeanDupont',
]);

$this->samApiClient->createActivityByInternalNumber('internalNumber', 'A020', [
    'status' => UpdateActivityInputState::Paused,
    'date' => new \DateTime,
    'employeeCode' => 'JeanDupont',
]);

$this->samApiClient->createActivityByExternalId('externalId', 'A020', [
    'status' => UpdateActivityInputState::Paused,
    'date' => new \DateTime,
    'employeeCode' => 'JeanDupont',
]);
```

| option name     | type                            |
|-----------------|---------------------------------|
| status          | UpdateActivityInputState        |
| date            | DateTimeInterface, string, null |
| employeeCode    | string, null                    |

### Diagnostic methods

#### Create diagnostic

```php
use IDCI\Bundle\SAMClientBundle\Client\SAMApiClient;
use IDCI\Bundle\SAMClientBundle\Client\Model\Enum\CreateDiagnosticInputWatchStateProductState;
...
$this->samApiClient->createDiagnotic(20000, [
    'date' => new \DateTime,
    'watchStates' => [
        [
            'toPrint' => false,
            'internalComment' => 'Fermoir cassé',
            'materialReference' => 'xxxxxx',
            'productState' => CreateDiagnosticInputWatchStateProductState::Broken,
        ],
    ],
    'operations' => [
        [
            'toPrint' => false,
            'internalComment' => 'Remplacement fermoir',
            'materialReference' => 'xxxxxx',
            'mandatory' => true,
            'main' => false,
            'quantity' => 1.00,
        ],
    ],
]);

$this->samApiClient->createDiagnosticByInternalNumber('internalNumber', [
    'date' => new \DateTime,
    'watchStates' => [
        [
            'toPrint' => false,
            'internalComment' => 'Fermoir cassé',
            'materialReference' => 'xxxxxx',
            'productState' => CreateDiagnosticInputWatchStateProductState::Broken,
        ],
    ],
    'operations' => [
        [
            'toPrint' => false,
            'internalComment' => 'Remplacement fermoir',
            'materialReference' => 'xxxxxx',
            'mandatory' => true,
            'main' => false,
            'quantity' => 1.00,
        ],
    ],
]);

$this->samApiClient->createDiagnosticByExternalId('externalId', [
    'date' => new \DateTime,
    'watchStates' => [
        [
            'toPrint' => false,
            'internalComment' => 'Fermoir cassé',
            'materialReference' => 'xxxxxx',
            'productState' => CreateDiagnosticInputWatchStateProductState::Broken,
        ],
    ],
    'operations' => [
        [
            'toPrint' => false,
            'internalComment' => 'Remplacement fermoir',
            'materialReference' => 'xxxxxx',
            'mandatory' => true,
            'main' => false,
            'quantity' => 1.00,
        ],
    ],
]);
```

| option name     | type                            |
|-----------------|---------------------------------|
| date            | DateTimeInterface, string, null |
| watchStates     | array, null                     |
| operations      | array, null                     |

### Business deal methods

#### Create business deal

```php
use IDCI\Bundle\SAMClientBundle\Client\SAMApiClient;
...
$this->samApiClient->createBusinessDeal([
    'externalId' => 'externalRef',
    'partnerReference' => 'FR center',
    'brandReference' => 'Brand 002',
    'partnerSiteReference' => 'xxxxx',
    'initialRequestorPartnerSiteReference' => 'xxxxx',
    'initialRequestorPartnerReference' => 'xxxxx',
    'invoicingCode' => '001',
    'internalNumber' => 'internalRef',
    'productNature' => 'Watch',
    'productReference' => 'xxxxx',
    'productSerialNumber' => 'xxxxx'
    'batchReference' => 'xxxxx',
    'movementSerialNumberReference' => 'xxxxx',
    'movementReference' => 'xxxxx',
    'interventionCode' => 'INV',
    'progress' => [
        'receptionDate' => new \DateTime,
        'estimateDate' => null,
        'expectedDeliveryDate' => null,
        'workStartDate' => null,
        'workEndDate' => null,
        'deliveryDate' => null,
        'numberDaysWaitingParts' => 2,
    ],
    'accessCode' => 'trackingCode',
    'quickService' => true,
    'interventionInvoicingCode' => '000',
]);
```

| option name                          | type                            |
|--------------------------------------|---------------------------------|
| externalId*                          | string                          |
| partnerReference*                    | string                          |
| brandReference*                      | string                          |
| partnerSiteReference                 | string, null                    |
| initialRequestorPartnerSiteReference | string, null                    |
| initialRequestorPartnerReference     | string, null                    |
| invoicingCode                        | string, null                    |
| internalNumber                       | string, null                    |
| productNature                        | string, null                    |
| productReference                     | string, null                    |
| productSerialNumber                  | string, null                    |
| batchReference                       | string, null                    |
| movementSerialNumberReference        | string, null                    |
| movementReference                    | string, null                    |
| interventionCode                     | string, null                    |
| progress                             | BusinessDealProgress, array     |
| accessCode                           | string, null                    |
| quickService                         | bool, null                      |
| interventionInvoicingCode            | string, null                    |

#### Get business deal

```php
use IDCI\Bundle\SAMClientBundle\Client\SAMApiClient;
...
$this->samApiClient->getBusinessDeal(20000);

$this->samApiClient->getBusinessDealByInternalNumber('internalNumber');

$this->samApiClient->getBusinessDealByExternalId('externalId');

$this->samApiClient->getBusinessDealsModifiedSince('2024-12-01');
```

#### Update business deal

```php
use IDCI\Bundle\SAMClientBundle\Client\SAMApiClient;
use IDCI\Bundle\SAMClientBundle\Client\Model\Enum\JsonPatchDocumentOperation;
...
$this->samApiClient->updateBusinessDeal(20000, [
    'jsonPatchDocuments' => [
        [
            'op' => JsonPatchDocumentOperation::Add,
            'path' => '',
            'value' => 'new value',
            'from' => '',
        ],
    ],
]);

$this->samApiClient->updateBusinessDealByInternalNumber('internalNumber', [
    'jsonPatchDocuments' => [
        [
            'op' => JsonPatchDocumentOperation::Add,
            'path' => '',
            'value' => 'new value',
            'from' => '',
        ],
    ],
]);

$this->samApiClient->updateBusinessDealByExternalId('externalId', [
    'jsonPatchDocuments' => [
        [
            'op' => JsonPatchDocumentOperation::Add,
            'path' => '',
            'value' => 'new value',
            'from' => '',
        ],
    ],
]);
```

| option name                          | type                            |
|--------------------------------------|---------------------------------|
| jsonPatchDocuments                   | array                           |

#### Delete business deal

```php
use IDCI\Bundle\SAMClientBundle\Client\SAMApiClient;
...
$this->samApiClient->deleteBusinessDeal(20000);

$this->samApiClient->deleteBusinessDealByInternalNumber('internalNumber');

$this->samApiClient->deleteBusinessDealByExternalId('externalId');
```

## Support

If needed, you can contact [Maëva](mailto:maeva.grondin@idci-consulting.fr).
