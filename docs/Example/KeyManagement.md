# Generate key pair, export in pem, sign, and verify a message example:

```php
use Casper\Util\Crypto\Ed25519Key;
use Casper\Util\Crypto\Secp256K1Key;

$keyPair = new Ed25519Key();
// or
$keyPair = new Secp256K1Key();
```

```php
$publicKeyPemString = $keyPair->exportPublicKeyInPem();
$privateKeyPemString = $keyPair->exportPrivateKeyInPem();

$message = 'Hello';
$signature = $keyPair->sign($message);

$isVerified = $keyPair->verify($signature, $message);
```
