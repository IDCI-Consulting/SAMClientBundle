# IDCI SAM Client Bundle

Symfony bundle that provides an api client for SAM app (SAVInsight)

## Installation

Install this bundle using composer:

```sh
composer require idci/sam-client-bundle
```

## Configuration

In `config/packages/`, create a `idci_sam_client.yaml` file :

```yaml
idci_sam_client:
    client_id: '%env(string:IDCI_SAM_CLIENT_ID)%'
    client_secret: '%env(string:IDCI_SAM_CLIENT_SECRET)%'
    mode: '%env(string:IDCI_SAM_MODE)%'
```

Required parameters:
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
