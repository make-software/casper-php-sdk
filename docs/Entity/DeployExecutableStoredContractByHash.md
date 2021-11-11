# DeployExecutableStoredContractByHash

```php
getHash(): string
```
Returns hex-encoded hash string

---
```php
getEntryPoint(): string
```
Returns an entry point string

---
```php
toBytes(): array
```
Converts current `DeployExecutableStoredContractByHash` to the byte array

---
```php
setArg(DeployNamedArg $deployNamedArg): self
```
Set [DeployNamedArg](DeployNamedArg.md) and return `self`

---
```php
getArgs(): array
```
Returns a list of [DeployNamedArg](DeployNamedArg.md) or empty list if no args

---
```php
getArgByName(string $name): ?DeployNamedArg
```
Returns [DeployNamedArg](DeployNamedArg.md) by name or `null` if args is empty
