# DeployExecutableFactory

```php
static newStandardPayment($amount): DeployExecutableModuleBytes
```
##### Parameters:

| Name | Type | Description | Required |
|---|---|---|---|
| `$amount`| `string` `int` `\GMP` | Amount of standard payment | Yes |

---
```php
static newTransfer($id, $amount, $target, CLURef $sourcePurse = null): DeployExecutableTransfer
```
##### Parameters:

| Name | Type | Description | Required |
|---|---|---|---|
| `$id`| `string` `int` `\GMP` | New transfer id | Yes |
| `$amount`| `string` `int` `\GMP` | Transfer amount | Yes |
| `$target`| `CLURef` `CLPublicKey` | Recipient public key or URef | Yes |
| `$sourcePurse`| `CLURef` | Source purse | Yes |

---
```php
static newModuleBytes(string $hexModuleBytes, array $args): DeployExecutableModuleBytes
```
##### Parameters:

| Name | Type               | Description              | Required |
|---|--------------------|--------------------------|---|
| `$hexModuleBytes`| `string`           | Hex-encoded module bytes | Yes |
| `$args`| `DeployNamedArg[]` | Arguments                | Yes |

---
```php
static newStoredContractByHash(string $entrypoint, array $args, string $hexContractHash): DeployExecutableStoredContractByHash
```
##### Parameters:

| Name | Type               | Description               | Required |
|---|--------------------|---------------------------|---|
| `$entrypoint`| `string`           | Entrypoint name           | Yes |
| `$args`| `DeployNamedArg[]` | Arguments                 | Yes |
| `$hexContractHash`| `string`           | Hex-encoded contract hash | Yes |

---
```php
static newStoredContractByName(string $entrypoint, array $args, string $contractAlias): DeployExecutableStoredContractByName
```
##### Parameters:

| Name | Type               | Description     | Required |
|---|--------------------|-----------------|---|
| `$entrypoint`| `string`           | Entrypoint name | Yes |
| `$args`| `DeployNamedArg[]` | Arguments       | Yes |
| `$contractAlias`| `string`           | Contract alias  | Yes |

---
```php
static newStoredContractPackageByHash(string $entrypoint, array $args, string $hexContractPackageHash, int $version = null): DeployExecutableStoredVersionedContractByHash
```
##### Parameters:

| Name               | Type               | Description                       | Required |
|--------------------|--------------------|-----------------------------------|----------|
| `$entrypoint`      | `string`           | Entrypoint name                   | Yes      |
| `$args`            | `DeployNamedArg[]` | Arguments                         | Yes      |
| `$hexContractHash` | `string`           | Hex-encoded contract package hash | Yes      |
| `$version`         | `int`              | Contract package version          | No       |

---
```php
static newStoredContractPackageByName(string $entrypoint, array $args, string $contractPackageAlias, int $version = null): DeployExecutableStoredVersionedContractByName
```
##### Parameters:

| Name               | Type               | Description            | Required |
|--------------------|--------------------|------------------------|----------|
| `$entrypoint`      | `string`           | Entrypoint name        | Yes      |
| `$args`            | `DeployNamedArg[]` | Arguments              | Yes      |
| `$contractPackageAlias` | `string`           | Contract package alias | Yes      |
| `$version`         | `int`              | Contract version       | No       |

