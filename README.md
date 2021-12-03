# casper-php-sdk
The PHP SDK allows developers to interact with the Casper Network using PHP. This page covers different examples of using the SDK.

## Install
```
composer require make-software/casper-php-sdk
```

## Usage
### Creating RpcClient
Create `RpcClient` by passing node url to constructor
```php
$nodeUrl = 'http://127.0.0.1:7777';
$client = new Casper\Rpc\RpcClient($nodeUrl);
```

### RPC call examples
You can find all RpcClient methods on the [RpcClientAPI page](docs/API/RpcClientAPI.md). Here you can see a several of examples of using RpcClient. All examples below are supposed to be ran against the Testnet

#### Get deploy by deploy hash
```php
$deploy = $client->getDeploy('fa815fc43c38da30f6ab4e5a6c8a1b31f09df2bf4b344019ffef60c1270d4e49');

$deployHeader = $deploy->getHeader();
$creationTime = $deployHeader->getTimestamp();
```

#### Get auction state information
```php
$auctionState = $client->getAuctionState();

$stateRootHash = $auctionState->getStateRootHash();
$blockHeight = $auctionState->getBlockHeight();
```

#### Get peers from the network
```php
$peers = $client->getPeers();

foreach ($peers as $peer) {
    ...
}
```

#### Get the latest block information
```php
$latestBlock = $client->getLatestBlock();
$latestBlockHash = $latestBlock->getHash();
```

## More examples
- [Key management](docs/Example/KeyManagement.md)
- [Sending a Transfer](docs/Example/SendingTransfer.md)
- [Event Stream](docs/Example/EventStream.md)

## API
### RpcClient
- [RpcClient](docs/API/RpcClientAPI.md#Constructor)
- [putDeploy](docs/API/RpcClientAPI.md#Put-deploy)
- [getDeploy](docs/API/RpcClientAPI.md#Get-deploy)
- [getBlockByHash](docs/API/RpcClientAPI.md#Get-block-by-hash)
- [getBlockByHeight](docs/API/RpcClientAPI.md#Get-block-by-height)
- [getLatestBlock](docs/API/RpcClientAPI.md#Get-the-latest-block)
- [getPeers](docs/API/RpcClientAPI.md#Get-peers)
- [getStatus](docs/API/RpcClientAPI.md#Get-status)
- [getAuctionState](docs/API/RpcClientAPI.md#Get-auction-state)
- [getStateRootHash](docs/API/RpcClientAPI.md#Get-state-root-hash)
- [getAccount](docs/API/RpcClientAPI.md#Get-account)
- [getAccountBalance](docs/API/RpcClientAPI.md#Get-account-balance)
- [getAccountBalanceUrefByAccountHash](docs/API/RpcClientAPI.md#Get-account-balance-URef-by-account-hash)
- [getAccountBalanceUrefByPublicKey](docs/API/RpcClientAPI.md#Get-account-balance-URef-by-public-key)
- [getBlockState](docs/API/RpcClientAPI.md#Get-block-state)
- [getBlockTransfers](docs/API/RpcClientAPI.md#Get-block-transfers)
- [getEraSummaryBySwitchBlockHash](docs/API/RpcClientAPI.md#Get-era-summary-by-switch-block-hash)
- [getEraSummaryBySwitchBlockHeight](docs/API/RpcClientAPI.md#Get-era-summary-by-switch-block-height)
- [getDictionaryItemByURef](docs/API/RpcClientAPI.md#Get-dictionary-item)

### DeployService
- [makeDeploy](docs/API/DeployServiceAPI.md#Make-deploy)
- [signDeploy](docs/API/DeployServiceAPI.md#Sign-deploy)
- [validateDeploy](docs/API/DeployServiceAPI.md#Validate-deploy)
- [getDeploySize](docs/API/DeployServiceAPI.md#Get-deploy-size)

## Entities
- [Account](docs/Entity/Account.md)
- [AuctionState](docs/Entity/AuctionState.md)
- [Block](docs/Entity/Block.md)
- [Deploy](docs/Entity/Deploy.md)
- [EraSummary](docs/Entity/EraSummary.md)
- [Transfer](docs/Entity/Transfer.md)

## Testing
Run the following command from the project directory. 

**Replace `http://127.0.0.1:7777` by the any Testnet node url before running**
```shell
export CASPER_PHP_SDK_TEST_NODE_URL="http://127.0.0.1:7777" && php vendor/bin/phpunit tests
```

## Roadmap
- [x] Create an RPC client that returns array responses
- [x] Implement all GET requests
- [x] Add `Ed25519` key support
- [x] Add `CLType` primitives
- [x] Add domain-specific entities
- [x] Add deploy creation related services
- [x] Add `Secp256k1` key support
- [ ] Add extensive validations
- [ ] Add automated tests
- [x] Add documentation
