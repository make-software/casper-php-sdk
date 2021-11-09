# Transfer
Class that represents a transfer from one purse to another

---
```php
getDeployHash(): string
```
Returns hex-encoded hash string of the deploy that created the transfer

---
```php
getFrom(): CLAccountHash
```
Returns `CLAccountHash` object that representing account's hash from which transfer was executed

---
```php
getTo(): ?CLAccountHash
```
Returns `CLAccountHash` object that representing account's hash to which funds was transferred

---
```php
getSource(): CLURef
```
Returns `CLURef` object that representing source purse

---
```php
getTarget(): CLURef
```
Returns `CLURef` object that representing target purse

---
```php
getAmount(): \GMP
```
Returns transfer amount

---
```php
getGas(): \GMP
```
Returns transfer gas

---
```php
getId(): ?int
```
Returns user-defined transfer id
