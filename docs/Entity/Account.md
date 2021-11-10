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

## JSON Representation
```json
{
    "account_hash": "account-hash-7203e3b0592b7ed4f6d552829c1887c493e525fb35b842aed68c56bec38f4e62",
    "named_keys": [],
    "main_purse": "uref-b9fcc2dca866a0eee6458bcb63933edd1893a136b812dd850cebc2de8fb15c08-007",
    "associated_keys": [
        {
            "account_hash": "account-hash-7203e3b0592b7ed4f6d552829c1887c493e525fb35b842aed68c56bec38f4e62",
            "weight": 1
        }
    ],
    "action_thresholds": {
        "deployment": 1,
        "key_management": 1
    }
}
```
