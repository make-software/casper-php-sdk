# Sending a Transfer

Prepare an instance of the client and a couple of keys that will be used during the example:
```php
$nodeAddress = 'http://127.0.0.1:7777'
$rpcClient = new Casper\Rpc\RpcClient($nodeAddress);

// Replace '/path/to/secp256k1_secret_key.pem' by real path to secret key
$senderKeyPair = Casper\Util\Crypto\Secp256K1Key::createFromPrivateKeyFile('/path/to/secp256k1_secret_key.pem');
$senderPublicKey = Casper\Serializer\CLPublicKeySerializer::fromAsymmetricKey($senderKeyPair);

// Replace 'recipient_hex_public_key_here' by real public key
$recipientPublicKey = Casper\Serializer\CLPublicKeySerializer::fromHex('recipient_hex_public_key_here');
```

Create new transfer by calling `Casper\Entity\DeployExecutable::newTransfer` method with passed custom transfer id and transfer amount to this method
```php
$transferId = 1;
$transferAmount = 2500000000;
$transfer = Casper\Entity\DeployExecutable::newTransfer($transferId, $transferAmount, $recipientPublicKey);
```

Create new standard payment by calling `Casper\Entity\DeployExecutable::newStandardPayment` method with passed payment amount
```php
$paymentAmount = 10;
$payment = Casper\Entity\DeployExecutable::newStandardPayment($paymentAmount);
```

Create deploy params and make new deploy
```php
$networkName = 'casper';
$deployParams = new Casper\Entity\DeployParams($senderPublicKey, $networkName);

$deploy = DeployService::makeDeploy($deployParams, $transfer, $payment);
```

Sign deploy and put to the network
```php
$signedDeploy = DeployService::signDeploy($deploy, $senderKeyPair);
$deployHash = $rpcClient->putDeploy($signedDeploy);
```
