# BidInfo

```php
getBondingPurse(): CLURef
```
Returns `CLURef` object that representing validator's bonding purse

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
Returns a list of [Delegator](Delegator.md) objects

---
```php
isInactive(): bool
```
Returns `true` if the validator is inactive 
