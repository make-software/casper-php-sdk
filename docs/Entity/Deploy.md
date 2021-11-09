# Deploy

---
```php
getHash(): array
```
Returns deploy hash byte array

---
```php
getHeader(): DeployHeader
```
Returns [DeployHeader](DeployHeader.md) object

---
```php
getPayment(): DeployExecutable
```
Returns [DeployExecutable](DeployExecutable.md) object that representing deploy payment

---
```php
isStandardPayment(): bool
```
Returns `true` if deploy payment is standard payment

---
```php
getSession(): DeployExecutable
```
Returns [DeployExecutable](DeployExecutable.md) object that representing deploy session

---
```php
isTransfer(): bool
```
Returns `true` if deploy session is transfer

---
```php
getApprovals(): array
```
Return a list of [DeployApproval](DeployApproval.md) objects

---
```php
pushApproval(DeployApproval $approval): self
```
Push [DeployApproval](DeployApproval.md) to deploy and returns `self` object
##### Parameters

| Name | Type | Description | Required |
|---|---|---|---|
| `$approval`| `DeployApproval` | [DeployApproval](DeployApproval.md) object | Yes |
