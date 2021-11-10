# Key management
Use the Ed25519Key or Secp256K1Key classes to work with public/private key pairs.

## Creating new key pairs
```php
$newKeyPair = new Casper\Util\Crypto\Ed25519Key();
```
```php
$anotherKeyPair = new Casper\Util\Crypto\Secp256K1Key();
```

## Reading keys from PEM files
To read a key from a PEM file use the method `createFromPrivateKeyFile()`
```php
$keyPair = \Casper\Util\Crypto\Ed25519Key::createFromPrivateKeyFile('/tmp/my_ed25519_pk.pem');
```
```php
$anotherKeyPair = \Casper\Util\Crypto\Secp256K1Key::createFromPrivateKeyFile('/tmp/my_secp256k1_pk.pem');
```

## Exporting to PEM
When you create a new key you may want to save the private part in a file for later usage.
```php
$privateKeyPemString = $keyPair->exportPrivateKeyInPem();
file_put_contents('/tmp/private_key.pem', $privateKeyPemString);
```
You can also export the public key part
```php
$publicKeyPemString = $keyPair->exportPublicKeyInPem();
file_put_contents('/tmp/public_key.pem', $publicKeyPemString);
```

## Signing and verifying
You can sign any message by `sign()` method and verify signature by `verify()` method
```php
$message = 'Hello';

$signature = $keyPair->sign($message);
$isVerified = $keyPair->verify($signature, $message);
```
