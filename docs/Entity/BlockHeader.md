# BlockHeader

```php
getParentHash(): string
```
Returns a parent block hex-encoded hash string

---
```php
getStateRootHash(): string
```
Returns global state hex-encoded hash string

---
```php
getBodyHash(): string
```
Returns a block body hex-encoded hash string

---
```php
isRandomBit(): bool
```
Returns is_random bit flag

---
```php
getAccumulatedSeed(): string
```
Returns hex-encoded hash string

---
```php
getEraEnd(): ?EraEnd
```
Returns [EraEnd](EraEnd.md) object or `null`

---
```php
getTimestamp(): int
```
Returns a block creation time

---
```php
getEraId(): int
```
Returns era id

---
```php
getHeight(): int
```
Returns a block height

---
```php
getProtocolVersion(): string
```
Returns Casper Platform protocol version
