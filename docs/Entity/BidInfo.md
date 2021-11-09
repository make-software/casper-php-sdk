# BidInfo

```php
getBondingPurse(): CLURef
```
Returns `CLURef` object that representing validator's bounding purse

---
```php
getStakedAmount(): \GMP
```
Returns validator's staked amount

---
```php
getDelegationRate(): int
```
Returns validator's delegation rate

---
```php
getDelegators(): array
```
Returns list of [Delegator](Delegator.md) objects

---
```php
isInactive(): bool
```
Returns `true` if the validator is inactive 
