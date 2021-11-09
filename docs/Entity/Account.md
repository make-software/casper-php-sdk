# Account
An account is a cryptographically secured gateway into the Casper system used by entities outside the blockchain (e.g., off-chain components of blockchain-based applications, individual users). All user activity on the Casper blockchain (i.e., “deploys”) must originate from an account. Each account has its own context where it can locally store information (e.g., references to useful contracts, metrics, aggregated data from other parts of the blockchain). Each account also has a “main purse” where it can hold Casper tokens

---
```php
getAccountHash(): CLAccountHash
```
Returns `CLAccountHash` object that representing the account hash

---
```php
getMainPurse(): CLURef
```
Returns account `CLURef` object that representing the account's main purse

---
```php
getNamedKeys(): array
```
Returns list of the account named keys

---
```php
getAssociatedKeys(): array
```
Returns list of [AssociatedKey](AssociatedKey.md) objects

---
```php
getActionThresholds(): ActionThresholds
```
Returns the account's [ActionThresholds](ActionThresholds.md)
