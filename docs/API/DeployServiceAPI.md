# DeployService API

---
## Make deploy
```php
static makeDeploy(DeployParams $deployParams, DeployExecutable $session, DeployExecutable $payment): Deploy
```
Returns new deploy object created by `$deployParams` with `$session` and `$payment`
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$deployParams` | `DeployParams` | Deploy parameters | Yes |
| `$session` | `DeployExecutable` | Session object | Yes |
| `$payment` | `DeployExecutable` | Payment object | Yes |

---
## Sign deploy
```php
static signDeploy(Deploy $deploy, AsymmetricKey $key): Deploy
```
Signs and returns the `$deploy` object
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$deploy` | `Deploy` | [Deploy](../Entity/Deploy.md) object which need to sign by `$key` | Yes |
| `$key` | `AsymmetricKey` | Asymmetric key object. Can be instance of `Casper\Util\Crypto\Ed25519Key` or `Casper\Util\Crypto\Secp256K1Key` | Yes |

---
## Validate deploy
```php
static validateDeploy(Deploy $deploy): bool
```
Returns `true` if both the deploy body hash and the deploy hash are valid
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$deploy` | `Deploy` | [Deploy](../Entity/Deploy.md) object | Yes |

---
## Get deploy size
```php
static getDeploySize(Deploy $deploy): int
```
Returns a deploy size in bytes
### Parameters
| Name | Type | Description | Required |
|---|---|---|---|
| `$deploy` | `Deploy` | [Deploy](../Entity/Deploy.md) object | Yes |
