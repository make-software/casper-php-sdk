# Deploy

A deploy represents a request from a user to perform computation on casper platform. It has the following information:

- Deploy hash: the blake2b256 hash of the Header
- Header: containing
  - the identity key of the account the deploy will run in
  - the timestamp when the deploy was created
  - a time to live, after which the deploy is expired and cannot be included in a block
  - the blake2b256 hash of the body
- Body: containing payment code and session code
- Approvals: the set of signatures which have signed the deploy hash, these are used in the account permissions model

Each deploy is an atomic piece of computation in the sense that, whatever effects a deploy would have on the global state must be entirely included in a block or the entire deploy must not be included in a block.

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
