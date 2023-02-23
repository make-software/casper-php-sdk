# Install contract

Load wasm and create contract arguments
```php
use Casper\Util\ByteUtil;

use Casper\CLType\CLString;
use Casper\CLType\CLU64;
use Casper\CLType\CLU8;

use Casper\Entity\DeployNamedArg;

$wasmBytes = ByteUtil::stringToByteArray(
    file_get_contents('path_to_cep78_contract_ces.wasm')
);
$args = array(
    new DeployNamedArg('collection_name', new CLString('my-collection')),
    new DeployNamedArg('collection_symbol', new CLString('MY-NFTS')),
    new DeployNamedArg('total_token_supply', new CLU64(2000)),
    new DeployNamedArg('ownership_mode', new CLU8(2)), // Transferable
    new DeployNamedArg('nft_kind', new CLU8(0)), // Physical
    new DeployNamedArg('json_schema', new CLString(json_encode(array(
        'properties' => array(
            'color' => array(
                'name' => 'color',
                'description' => '',
                'required' => true,
            ),
            'size' => array(
                'name' => 'size',
                'description' => '',
                'required' => true,
            ),
            'material' => array(
                'name' => 'material',
                'description' => '',
                'required' => true,
            ),
            'condition' => array(
                'name' => 'condition',
                'description' => '',
                'required' => false,
            )
        )
    )))),
    new DeployNamedArg('nft_metadata_kind', new CLU8(3)), // CustomValidated
    new DeployNamedArg('identifier_mode', new CLU8(0)), // Ordinal
    new DeployNamedArg('metadata_mutability', new CLU8(1)), // Mutable
    new DeployNamedArg('events_mode', new CLU8(1)),
    new DeployNamedArg('minting_mode', new CLU8(1)), // Public
    new DeployNamedArg('owner_reverse_lookup_mode', new CLU8(0)), // NoLookup
);
```

Install contract with created arguments
```php
use Casper\Serializer\CLPublicKeySerializer;
use Casper\Util\Crypto\Secp256K1Key;

use Casper\Rpc\RpcClient;
use Casper\Service\ContractService;

$rpcClient = new RpcClient('http://127.0.0.1:7777');
$paymentAmount = '350000000000';
$sender = CLPublicKeySerializer::fromHex('02037c094ee8461c8f2ff177fa6cf8a5770f2aa95d5dfb179f78173292c25d14ca62');
$chainName = 'casper-test';
$signingKeys = [
    Secp256K1Key::createFromPrivateKeyFile('path_to_pk.pem')
];

$deployHash = ContractService::install(
    $rpcClient,
    $wasmBytes,
    $args,
    $paymentAmount,
    $sender,
    $chainName,
    $signingKeys
);
```
