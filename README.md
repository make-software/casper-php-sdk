# casper-php-sdk
The PHP SDK allows developers to interact with the Casper Network using PHP. This page covers different examples of using the SDK.

## Install

```
composer require make-software/casper-php-sdk
```

## Examples

#### Obtain some information from the network:
```php
use Casper\Rpc\RpcClient;

$nodeUrl = 'http://127.0.0.1:7777';
$client = new RpcClient($nodeUrl);

$peers = $client->getPeers();
$latestBlock = $client->getLatestBlock();
$auctionState = $client->getAuctionState();
...
```

#### Generate key pair, export in pem, sign, and verify a message:
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

#### Sending a Transfer:
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

## SDK API

### RpcClient
Class for interacting with the network via RPC

#### Constructor
```php
__constructor(string $nodeUrl)
```
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$nodeUrl```| ```string``` | Full node url string | Yes |

#### Put deploy
```php
putDeploy(Deploy $deploy): string
```
Put deploy into the network and returns deploy hash string
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$deploy```| ```Deploy``` | Signed deploy object | Yes |

#### Get deploy
```php
getDeploy(string $deployHash): Deploy
```
Returns Deploy object by deploy hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$deployHash```| ```string``` | Deploy hash | Yes |

#### Get block by hash
```php
getBlock(string $blockHash): Block
```
Returns Block object by block hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$blockHash```| ```string``` | Block hash | Yes |

#### Get block by height
```php
getBlockByHeight(int $height): Block
```
Returns Block object by block height
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$height```| ```int``` | Block height | Yes |

#### Get the latest block
```php
getLatestBlock(): Block
```
Returns Block object that represent the latest block from network

#### Get peers
```php
getPeers(): array
```
Returns array of Peer objects

#### Get status
```php
getStatus(): Status
```
Returns Status object

#### Get auction state
```php
getAuctionState(): AuctionState
```
Returns AuctionState object

#### Get state root hash
```php
getStateRootHash(string $blockHash): string
```
Returns state root hash string by block hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$blockHash```| ```string``` | Block hash | Yes |

#### Get state root hash
```php
getStateRootHash(string $blockHash): string
```
Returns state root hash string by block hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$blockHash```| ```string``` | Block hash | Yes |

#### Get account balance
```php
getAccountBalance(string $stateRootHash, CLURef $balanceUref): \GMP
```
Returns account balance by state root hash and balance uref
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$stateRootHash```| ```string``` | State root hash | Yes |
| ```$balanceUref```| ```CLURef``` | Balance uref object | Yes |

#### Get account balance uref by account hash
```php
getAccountBalanceUrefByAccountHash(string $stateRootHash, CLAccountHash $accountHash): CLURef
```
Returns account balance uref by state root hash and account hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$stateRootHash```| ```string``` | State root hash | Yes |
| ```$accountHash```| ```CLAccountHash``` | Account hash object | Yes |

#### Get account balance uref by public key
```php
getAccountBalanceUrefByPublicKey(string $stateRootHsh, CLPublicKey $publicKey): CLURef
```
Returns account balance uref by state root hash and public key
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$stateRootHash```| ```string``` | State root hash | Yes |
| ```$publicKey```| ```CLPublicKey``` | Public key object | Yes |

#### Get block state
```php
getBlockState(string $stateRootHash, string $key, array $path = []): StoredValue
```
Returns StoredValue object by state root hash, key and path
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$stateRootHash```| ```string``` | State root hash | Yes |
| ```$key```| ```string``` | Key | Yes |
| ```$path```| ```array``` | Path | No |

#### Get block transfers
```php
getBlockTransfers(string $blockHash = null): array
```
Returns array of Transfer objects by block hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$blockHash```| ```string``` | Block hash | No |

#### Get era summary by switch block hash
```php
getEraSummaryBySwitchBlockHash(string $blockHash): ?EraSummary
```
Returns EraSummary object or null by block hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$blockHash```| ```string``` | Block hash | Yes |

#### Get era summary by switch block height
```php
getEraSummaryBySwitchBlockHeight(int $height): ?EraSummary
```
Returns EraSummary object or null by block height
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$height```| ```int``` | Block height | Yes |

#### Get dictionary item
```php
getDictionaryItemByURef(
    string $stateRootHash,
    string $dictionaryItemKey,
    string $seedUref
): StoredValue
```
Returns dictionary item by state root hash, dictionary item key and seed uref
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$stateRootHash```| ```string``` | State root hash | Yes |
| ```$dictionaryItemKey```| ```string``` | Dictionary item key | Yes |
| ```$seedUref```| ```string``` | Seed uref | Yes |

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
