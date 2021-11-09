# SeigniorageAllocationDelegator
Class that contains info about a seigniorage allocation for a delegator

---
```php
getDelegatorPublicKey(): CLPublicKey
```
Returns `CLPublicKey` object that representing delegator's public key

---
```php
getValidatorPublicKey(): CLPublicKey
```
Returns `CLPublicKey` object that representing validator's public key


---
```php
getAmount(): \GMP
```
Returns allocated amount
