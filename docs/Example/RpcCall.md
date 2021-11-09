# Obtain some information from the network example:

```php
use Casper\Rpc\RpcClient;

$nodeUrl = 'http://127.0.0.1:7777';
$client = new RpcClient($nodeUrl);

$peers = $client->getPeers();
$latestBlock = $client->getLatestBlock();
$auctionState = $client->getAuctionState();
...
```
