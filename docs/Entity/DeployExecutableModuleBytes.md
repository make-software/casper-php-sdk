# DeployExecutableModuleBytes

```php
getModuleBytes(): string
```
Returns a module bytes string

---
```php
toBytes(): array
```
Converts current `DeployExecutableModuleBytes` to the byte array

---
```php
setArg(DeployNamedArg $deployNamedArg): self
```
Set [DeployNamedArg](DeployNamedArg.md) and returns `self`

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
