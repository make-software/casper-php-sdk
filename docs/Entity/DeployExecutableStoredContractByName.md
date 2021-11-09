# DeployExecutableStoredContractByName

```php
getHash(): string
```
Returns hex-encoded hash string

---
```php
getEntryPoint(): string
```
Returns entry point string

---
```php
toBytes(): array
```
Converts current `DeployExecutableStoredContractByName` to byte array

---
```php
setArg(DeployNamedArg $deployNamedArg): self
```
Set [DeployNamedArg](DeployNamedArg.md) and return `self`

---
```php
getArgs(): array
```
Returns array of [DeployNamedArg](DeployNamedArg.md) or empty array if no args

---
```php
getArgByName(string $name): ?DeployNamedArg
```
Returns [DeployNamedArg](DeployNamedArg.md) by name or `null` if args is empty
