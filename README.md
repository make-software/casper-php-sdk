# casper-php-sdk
PHP SDK to interact with Casper Network nodes via RPC

---
## Installation
```composer require casper/sdk```

---
## Examples
RPC Client:
```php
$client = new \Casper\Rpc\Client('https://node-clarity-testnet.make.services');

$validatorsInfo = $client->getValidatorsInfo();
$peers = $client->getPeers();
$latestBlockInfo = $client->getLatestBlockInfo();
...
```

Ed25519 key:
```php
$keyPair = \Casper\Entity\Ed25519Key::new();

// Export public and private keys into pem string
$publicKey = $keyPair->exportPublicKeyInPem();
$privateKey = $keyPair->exportPrivateKeyInPem();

// Sign the message
$message = [1,2,3];
$signature = $keyPair->sign($message);

// Verify signature
$verified = $keyPair->verify($signature, $message);
```

---
## Roadmap
- [x] Create an RPC client that returns array responses
- [x] Implement all GET requests
- [x] Add Ed25519 key support
- [ ] Add CLType primitives
- [ ] Add domain-specific entities
- [ ] Add deploy creation related services
- [ ] Add Secp256k1 key support
- [ ] Add extensive validations
- [ ] Add automated tests
- [ ] Add documentation
