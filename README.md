# casper-php-sdk
The PHP SDK allows developers to interact with the Casper Network using PHP. This page covers different examples of using the SDK.

## Install
```
composer require make-software/casper-php-sdk
```

## API
### RpcClient
- [__constructor](docs/API/RpcClientAPI.md#Constructor)
- [putDeploy](docs/API/RpcClientAPI.md#Put-deploy)
- [getDeploy](docs/API/RpcClientAPI.md#Get-deploy)
- [getBlock](docs/API/RpcClientAPI.md#Get-block-by-hash)
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

## Entity
- [Account](docs/Entity/Account.md)
- [AuctionState](docs/Entity/AuctionState.md)
- [Bid](docs/Entity/Bid.md)
- [Block](docs/Entity/Block.md)
- [Contract](docs/Entity/Contract.md)
- [Deploy](docs/Entity/Deploy.md)
- [EraSummary](docs/Entity/EraSummary.md)
- [Transfer](docs/Entity/Transfer.md)

## Examples
- [RPC Client](docs/Example/RPCClient.md)
- [Key management](docs/Example/KeyManagement.md)
- [Sending a Transfer](docs/Example/SendingTransfer.md)

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
