# AuctionState

Class that summarizing auction contract data

---
```php
getStateRootHash(): string
```
Returns global state hex-encoded hash string

---
```php
getBlockHeight(): int
```
Returns the last block height

---
```php
getEraValidators(): array
```
Returns list of `EraValidator` objects for the current era and the next era

---
```php
getBids(): array
```
Returns list of [Bid](Bid.md) objects


