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

Keys:
```php
$key = new \Casper\Util\Crypto\Ed25519Key();
// or
$key = new \Casper\Util\Crypto\Secp256K1Key();
```

```php
// Export public and private keys into pem string
$publicKey = $key->exportPublicKeyInPem();
$privateKey = $key->exportPrivateKeyInPem();

// Sign the message
$message = 'Hello';
$signature = $key->sign($message);

// Verify signature
$verified = $key->verify($signature, $message);
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
- [ ] Add documentation
