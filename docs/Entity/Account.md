# Account
Account is a cryptographically secured gateway into the Casper system used by entities outside the blockchain (e.g., off-chain components of blockchain-based applications, individual users). All user activity on the Casper blockchain (i.e., “deploys”) must originate from an account. Each account has its own context where it can locally store information (e.g., references to useful contracts, metrics, aggregated data from other parts of the blockchain). Each account also has a “main purse” where it can hold Casper tokens

---
```php
getAccountHash(): CLAccountHash
```
Returns `CLAccountHash` object that representing an account hash

---
```php
getMainPurse(): CLURef
```
Returns an account `CLURef` object that representing account's main purse

---
```php
getNamedKeys(): array
```
Returns a list of the account named keys

---
```php
getAssociatedKeys(): array
```
Returns a list of [AssociatedKey](AssociatedKey.md) objects

---
```php
getActionThresholds(): ActionThresholds
```
Returns account's [ActionThresholds](ActionThresholds.md)

## JSON Representation
Below is an example of an account JSON returned by node RPC API
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
