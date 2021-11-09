# DeployExecutableTransfer

```php
toBytes(): array
```
Converts current `DeployExecutableTransfer` to byte array

---
```php
setArg(DeployNamedArg $deployNamedArg): self
```
Set [DeployNamedArg](DeployNamedArg.md) to current `DeployExecutableTransfer` and return `self`

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
