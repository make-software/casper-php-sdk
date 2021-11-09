# Sending a Transfer example:

```php
use Casper\Entity\DeployExecutable;
use Casper\Entity\DeployParams;
use Casper\Rpc\RpcClient;
use Casper\Serializer\CLPublicKeySerializer;
use Casper\Service\DeployService;
use Casper\Util\Crypto\Secp256K1Key;

// Replace '/path/to/secp256k1_secret_key.pem' by real path to secret key
$senderKeyPair = Secp256K1Key::createFromPrivateKeyFile('/path/to/secp256k1_secret_key.pem');
$senderPublicKey = CLPublicKeySerializer::fromAsymmetricKey($senderKeyPair);
$networkName = 'casper';
$deployParams = new DeployParams($senderPublicKey, $networkName);

// Replace 'recipient_hex_public_key_here' by real public key
$recipientPublicKey = CLPublicKeySerializer::fromHex('recipient_hex_public_key_here');
$transferId = 1;
$transferAmount = 2500000000;
$session = DeployExecutable::newTransfer($transferId, $transferAmount, $recipientPublicKey);

$paymentAmount = 10;
$payment = DeployExecutable::newStandardPayment($paymentAmount);

$deployService = new DeployService();
$deploy = $deployService->makeDeploy($deployParams, $session, $payment);
$signedDeploy = $deployService->signDeploy($deploy, $senderKeyPair);

$rpcClient = new RpcClient('http://127.0.0.1:7777');
$deployHash = $rpcClient->putDeploy($signedDeploy);
```
