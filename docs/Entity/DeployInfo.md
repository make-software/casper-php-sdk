# DeployInfo

```php
getDeployHash(): string
```
Returns hex-encoded hash string of the deploy

---
```php
getFrom(): CLAccountHash
```
Returns `CLAccountHash` object that representing account hash of the creator of the deploy.

---
```php
getSource(): CLURef
```
Returns `CLURef` object that representing source purse used for payment of the deploy

---
```php
getGas(): \GMP
```
Returns gas cost of executing the deploy

---
```php
getTransfers(): array
```
Returns list of hex-encoded transfers addresses, performed by the deploy
