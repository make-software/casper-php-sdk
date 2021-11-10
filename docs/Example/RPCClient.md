# RPC Client

## Creating RpcClient
Create `RpcClient` by passing node url to constructor
```php
$nodeUrl = 'http://127.0.0.1:7777';
$client = new Casper\Rpc\RpcClient($nodeUrl);
```

## RPC call examples
You can find all RpcClient methods on the [RpcClientAPI page](../API/RpcClientAPI). Here you can see a couple of examples of using RpcClient.

Get deploy by deploy hash
```php
$deploy = $client->getDeploy('a106ad497df577dc279e102e3a674b7d5b3637bab20897db1fb1ad1a72a21bfe');

$deployHeader = $deploy->getHeader();
$creationTime = $deployHeader->getTimestamp();
```

Get auction state information
```php
$auctionState = $client->getAuctionState();

$stateRootHash = $auctionState->getStateRootHash();
$blockHeight = $auctionState->getBlockHeight();
```

Get peers from the network
```php
$peers = $client->getPeers();

foreach ($peers as $peer) {
    ...
}
```

Get the latest block information
```php
$latestBlock = $client->getLatestBlock();
$latestBlockHash = $latestBlock->getHash();
```
