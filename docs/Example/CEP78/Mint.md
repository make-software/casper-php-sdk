# Mint

Create Contract service instance
```php
use Casper\Rpc\RpcClient;
use Casper\Service\ContractService;
use Casper\Service\DeployService;

$rpcClient = new RpcClient('http://127.0.0.1:7777');
$contractHash = '01c6876d5622518fc48fd31af2c4936f35ea1d3ebf4fdb44bd8935a0c2138df4';

$contractService = new ContractService(
    $rpcClient,
    $contractHash
);
```

Create arguments
```php
use Casper\Entity\DeployNamedArg;

use Casper\CLType\CLKey;
use Casper\CLType\CLString;

$args = array(
    new DeployNamedArg('token_owner', new CLKey(
        CLPublicKeySerializer::fromHex('02037c094ee8461c8f2ff177fa6cf8a5770f2aa95d5dfb179f78173292c25d14ca62')
    )),
    new DeployNamedArg('token_meta_data', new CLString(
        json_encode(array(
            'color' => 'Blue',
            'size' => 'Medium',
            'material' => 'Aluminum',
            'condition' => 'Used',
        ))
    )),
);
```

Call mint entrypoint with created arguments
```php
use Casper\Serializer\CLPublicKeySerializer;
use Casper\Util\Crypto\Secp256K1Key;

$entryPoint = 'mint';
$paymentAmount = '1200000000';
$sender = CLPublicKeySerializer::fromHex('02037c094ee8461c8f2ff177fa6cf8a5770f2aa95d5dfb179f78173292c25d14ca62');
$chainName = 'casper-test';
$signingKeys = [
    Secp256K1Key::createFromPrivateKeyFile('path_to_pk.pem')
];

$deployHash = $contractService->callEntrypoint(
    $entryPoint,
    $args,
    $paymentAmount,
    $sender,
    $chainName,
    $signingKeys
);
```
