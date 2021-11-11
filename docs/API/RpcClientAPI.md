# RpcClient API
Class for interacting with the network via RPC

---
## Constructor
```php
__constructor(string $nodeUrl)
```
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$nodeUrl` | `string` | Full node url string | Yes |

---
## Put deploy
```php
putDeploy(Deploy $deploy): string
```
Put deploy into the network and returns deploy hash `string`
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$deploy` | `Deploy` | Signed [Deploy](../Entity/Deploy.md) object | Yes |

---
## Get deploy
```php
getDeploy(string $deployHash): Deploy
```
Returns a [Deploy](../Entity/Deploy.md) object by the given deploy hash
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$deployHash` | `string` | Hex-encoded hash of a deploy | Yes |

---
## Get block by hash
```php
getBlockByHash(string $blockHash): Block
```
Returns a [Block](../Entity/Block.md) object by the given  block hash
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$blockHash` | `string` | Hex-encoded hash of a block | Yes |

---
## Get block by height
```php
getBlockByHeight(int $height): Block
```
Returns a [Block](../Entity/Block.md) object by the given  block height
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$height` | `int` | Block height | Yes |

---
## Get the latest block
```php
getLatestBlock(): Block
```
Returns a [Block](../Entity/Block.md) object that represents the latest block from the network

---
## Get peers
```php
getPeers(): array
```
Returns a list of [Peer](../Entity/Peer.md) objects connected to the node

---
## Get status
```php
getStatus(): Status
```
Returns the current [Status](../Entity/Status.md) of the node

---
## Get auction state
```php
getAuctionState(): AuctionState
```
Returns [AuctionState](../Entity/AuctionState.md) object that contains the bids and validators as of either if specific block (by height or hash), or the most recently added block

---
## Get state root hash
```php
getStateRootHash(string $blockHash): string
```
Returns state root hash `string` by the given block hash
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$blockHash` | `string` | Hex-encoded hash of the block | Yes |

---
## Get account
```php
getAccount(string $blockHash, CLPublicKey $publicKey): Account
```
Returns an [Account](../Entity/Account.md) object by the given block hash and account public key
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$blockHash` | `string` | Hex-encoded hash of the block | Yes |
| `$publicKey` | `CLPublicKey` | Public key object | Yes |

---
## Get account balance
```php
getAccountBalance(string $stateRootHash, CLURef $balanceUref): \GMP
```
Returns purse's balance from the network
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$stateRootHash` | `string` | Hex-encoded hash of the state root | Yes |
| `$balanceUref` | `CLURef` | Balance URef object | Yes |

---
## Get account balance URef by account hash
```php
getAccountBalanceUrefByAccountHash(string $stateRootHash, CLAccountHash $accountHash): CLURef
```
Returns an account balance URef by the given state root hash and account hash
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$stateRootHash` | `string` | Hex-encoded hash of the state root | Yes |
| `$accountHash` | `CLAccountHash` | Account hash object | Yes |

---
## Get account balance URef by public key
```php
getAccountBalanceUrefByPublicKey(string $stateRootHsh, CLPublicKey $publicKey): CLURef
```
Returns an account balance CLURef by the given state root hash and public key
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$stateRootHash` | `string` | Hex-encoded hash of the state root | Yes |
| `$publicKey` | `CLPublicKey` | Public key object | Yes |

---
## Get block state
```php
getBlockState(string $stateRootHash, string $key, array $path = []): StoredValue
```
Returns [StoredValue](../Entity/StoredValue.md) object by state root hash, key and path
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$stateRootHash` | `string` | Hex-encoded hash of the state root | Yes |
| `$key` | `string` | `casper_types::Key` as formatted string | Yes |
| `$path` | `array` | The path components starting from the key as base. | No |

---
## Get block transfers
```php
getBlockTransfers(string $blockHash = null): array
```
Returns a list of [Transfer](../Entity/Transfer.md) objects for the block from the network by the given block hash
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$blockHash` | `string` | Hex-encoded hash of the block | No |

---
## Get era summary by switch block hash
```php
getEraSummaryBySwitchBlockHash(string $blockHash): ?EraSummary
```
Returns an [EraSummary](../Entity/EraSummary.md) object or `null` by the given block hash
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$blockHash` | `string` | Hex-encoded hash of the block | Yes |

---
## Get era summary by switch block height
```php
getEraSummaryBySwitchBlockHeight(int $height): ?EraSummary
```
Returns an [EraSummary](../Entity/EraSummary.md) object or `null` by the given block height
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$height` | `int` | Block height | Yes |

---
## Get dictionary item
```php
getDictionaryItemByURef(
    string $stateRootHash,
    string $dictionaryItemKey,
    string $seedUref
): StoredValue
```
Returns an item from a Dictionary ([StoredValue](../Entity/StoredValue.md) object) by the given state root hash, dictionary item key and seed URef
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$stateRootHash` | `string` | Hex-encoded hash of the state root | Yes |
| `$dictionaryItemKey` | `string` | The dictionary item key formatted as a string | Yes |
| `$seedUref` | `string` | The dictionary's seed URef | Yes |
