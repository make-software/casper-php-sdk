# DeployExecutable

```php
static newStandardPayment($amount): self
```
Creates new standard payment and returns it
##### Parameters:

| Name | Type | Description | Required |
|---|---|---|---|
| `$amount`| `string` `int` `\GMP` | Amount of standard payment | Yes |

---
```php
static newTransfer($id, $amount, $target, CLURef $sourcePurse = null): self
```
Creates new transfer and returns it
##### Parameters:

| Name | Type | Description | Required |
|---|---|---|---|
| `$id`| `string` `int` `\GMP` | New transfer id | Yes |
| `$amount`| `string` `int` `\GMP` | Transfer amount | Yes |
| `$target`| `CLURef` `CLPublicKey` | Recipient public key or URef | Yes |
| `$sourcePurse`| `CLURef` | Source purse | Yes |

---
```php
toBytes(): array
```
Converts `DeployExecuatable` object to byte array

### Setters and getters for `DeployExecutable` internal objects
#### [DeployExecutableModuleBytes](DeployExecutableModuleBytes.md)
```php
setModuleBytes(?DeployExecutableModuleBytes $moduleBytes): self
```
```php
getModuleBytes(): ?DeployExecutableModuleBytes
```
```php
isModuleBytes(): bool
```

---
#### [DeployExecutableTransfer](DeployExecutableTransfer.md)
```php
setTransfer(?DeployExecutableTransfer $transfer): self
```
```php
getTransfer(): ?DeployExecutableTransfer
```
```php
isTransfer(): bool
```

---
#### [DeployExecutableStoredContractByHash](DeployExecutableStoredContractByHash.md)
```php
setStoredContractByHash(?DeployExecutableStoredContractByHash $storedContractByHash): self
```
```php
getStoredContractByHash(): ?DeployExecutableStoredContractByHash
```
```php
isStoredContractByHash(): bool
```

---
#### [DeployExecutableStoredContractByName](DeployExecutableStoredContractByName.md)
```php
setStoredContractByName(?DeployExecutableStoredContractByName $storedContractByName): self
```
```php
getStoredContractByName(): ?DeployExecutableStoredContractByName
```
```php
isStoredContractByName(): bool
```

---
#### [DeployExecutableStoredVersionedContractByHash](DeployExecutableStoredVersionedContractByHash.md)
```php
setStoredVersionedContractByHash(?DeployExecutableStoredVersionedContractByHash $storedVersionedContractByHash): self
```
```php
getStoredVersionedContractByHash(): ?DeployExecutableStoredVersionedContractByHash
```
```php
isStoredVersionedContractByHash(): bool
```

---
#### [DeployExecutableStoredVersionedContractByName](DeployExecutableStoredVersionedContractByName.md)
```php
setStoredVersionedContractByName(?DeployExecutableStoredVersionedContractByName $storedVersionedContractByName): self
```
```php
getStoredVersionedContractByName(): ?DeployExecutableStoredVersionedContractByName
```
```php
isStoredVersionedContractByName(): bool
```
