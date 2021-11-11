# AssociatedKey
The associated keys of an account are the set of public keys which are allowed to provide signatures on deploys for that account. Each associated key has a weight; these weights are used to meet the action thresholds. 

---
```php
getAccountHash(): CLAccountHash
```
Returns `CLAccountHash` object that representing an account hash

---
```php
getWeight(): int
```
Returns weight value
