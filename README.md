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
| ```$deploy```| ```Deploy``` | Signed Deploy object | Yes |

#### Get deploy
```php
getDeploy(string $deployHash): Deploy
```
Returns the `Deploy` object by the given deploy hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$deployHash```| ```string``` | Hex-encoded hash of the deploy | Yes |

#### Get block by hash
```php
getBlock(string $blockHash): Block
```
Returns the `Block` object by the given  block hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$blockHash```| ```string``` | Hex-encoded hash of the block | Yes |

#### Get block by height
```php
getBlockByHeight(int $height): Block
```
Returns the `Block` object by the given  block height
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$height```| ```int``` | Block height | Yes |

#### Get the latest block
```php
getLatestBlock(): Block
```
Returns the `Block` object that represents the latest block from network

#### Get peers
```php
getPeers(): array
```
Returns a list of peers (array of `Peer` objects) connected to the node

#### Get status
```php
getStatus(): Status
```
Returns the current status (`Status` object) of the node

#### Get auction state
```php
getAuctionState(): AuctionState
```
Returns `AuctionState` object that contains the bids and validators as of either if specific block (by height or hash), or the most recently added block

#### Get state root hash
```php
getStateRootHash(string $blockHash): string
```
Returns state root hash string by the given block hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$blockHash```| ```string``` | Hex-encoded hash of the block | Yes |

#### Get account
```php
getAccount(string $blockHash, CLPublicKey $publicKey): Account
```
Returns `Account` object by the given block hash and account public key
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$blockHash```| ```string``` | Hex-encoded hash of the block | Yes |
| ```$publicKey```| ```CLPublicKey``` | Public key object | Yes |

#### Get account balance
```php
getAccountBalance(string $stateRootHash, CLURef $balanceUref): \GMP
```
Returns purse's balance from the network
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$stateRootHash```| ```string``` | Hex-encoded hash of the state root | Yes |
| ```$balanceUref```| ```CLURef``` | Balance URef object | Yes |

#### Get account balance URef by account hash
```php
getAccountBalanceUrefByAccountHash(string $stateRootHash, CLAccountHash $accountHash): CLURef
```
Returns account balance URef object by the given state root hash and account hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$stateRootHash```| ```string``` | Hex-encoded hash of the state root | Yes |
| ```$accountHash```| ```CLAccountHash``` | Account hash object | Yes |

#### Get account balance URef by public key
```php
getAccountBalanceUrefByPublicKey(string $stateRootHsh, CLPublicKey $publicKey): CLURef
```
Returns account balance URef by the given state root hash and public key
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$stateRootHash```| ```string``` | Hex-encoded hash of the state root | Yes |
| ```$publicKey```| ```CLPublicKey``` | Public key object | Yes |

#### Get block state
```php
getBlockState(string $stateRootHash, string $key, array $path = []): StoredValue
```
Returns StoredValue object by state root hash, key and path
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$stateRootHash```| ```string``` | Hex-encoded hash of the state root | Yes |
| ```$key```| ```string``` | `casper_types::Key` as formatted string | Yes |
| ```$path```| ```array``` | The path components starting from the key as base. | No |

#### Get block transfers
```php
getBlockTransfers(string $blockHash = null): array
```
Returns all transfers (array of `Transfer` objects) for a Block from the network by the given block hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$blockHash```| ```string``` | Hex-encoded hash of the block | No |

#### Get era summary by switch block hash
```php
getEraSummaryBySwitchBlockHash(string $blockHash): ?EraSummary
```
Returns EraSummary object or null by the given block hash
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$blockHash```| ```string``` | Hex-encoded hash of the block | Yes |

#### Get era summary by switch block height
```php
getEraSummaryBySwitchBlockHeight(int $height): ?EraSummary
```
Returns EraSummary object or null by the given block height
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
Returns an item from a Dictionary (`StoredValue` object) by the given state root hash, dictionary item key and seed URef
##### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| ```$stateRootHash```| ```string``` | Hex-encoded hash of the state root | Yes |
| ```$dictionaryItemKey```| ```string``` | The dictionary item key formatted as a string | Yes |
| ```$seedUref```| ```string``` | The dictionary's seed URef | Yes |

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
