# EntryPoint

```php
getAccess(): string
```
Returns entry point access string

---
```php
getEntryPointType(): string
```
Returns entry point type string (Context of method execution). Can have `Session` or `Contract` string value.

---
```php
getName(): string
```
Returns an entry point name

---
```php
getRet(): CLType
```
Returns `CLType` object

---
```php
getArgs(): array
```
Returns a list of [NamedCLTypeArg](NamedCLTypeArg.md) objects
