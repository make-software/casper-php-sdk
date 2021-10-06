# casper-php-sdk
PHP SDK to interact with Casper Network nodes via RPC

## Install

```
composer require make-software/casper-php-sdk
```

## Examples
RPC Client:

```php
$nodeUrl = 'http://127.0.0.1:7777';
$client = new \Casper\Rpc\RpcClient($nodeUrl);

$peers = $client->getPeers();
$latestBlock = $client->getLatestBlock();
$auctionState = $client->getAuctionState();
...
```

Ed25519 key:
```php
$keyPair = new \Casper\Entity\Ed25519Key();

// Export public and private keys into pem string
$publicKey = $keyPair->exportPublicKeyInPem();
$privateKey = $keyPair->exportPrivateKeyInPem();

// Sign the message
$message = [1,2,3];
$signature = $keyPair->sign($message);

// Verify signature
$verified = $keyPair->verify($signature, $message);
```

## Roadmap
- [x] Create an RPC client that returns array responses
- [x] Implement all GET requests
- [x] Add `Ed25519` key support
- [x] Add `CLType` primitives
- [x] Add domain-specific entities
- [x] Add deploy creation related services
- [ ] Add `Secp256k1` key support
- [ ] Return `CLValue` types instead of `GMP`, `strings`, and byte arrays
- [ ] Get rid of redundant methods/abstractions (e.g. deploy arguments)
- [ ] Implement magic `__toString()` method for CLTypes where it makes sense
- [ ] Ensure polymorphic RPC method signatures that accept strings and CLTypes
- [ ] Add extensive validations
- [ ] Add automated tests
- [ ] Add documentation
