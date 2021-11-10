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

## JSON Representation
```json
{
    "deploy_hash": "f6c123456789c0ad77b58eccaa65f1901c37583c094a13c0b2b1c336cc4638f6",
    "from": "account-hash-15b87123456789020d433bcefcec8c57e168b6c248a33c0a4225a0e9671911e9",
    "to": "account-hash-58450dea3eeeafd6eb3a016c540dade123456789adffe31bce9ff2a922b7b1c1",
    "source": "uref-166b4d5edd2b1bc7123456789f38560b97d82dea5af1ed7d72b4894581a8dd01-007",
    "target": "uref-d10f7abbe91e2c6469b7b558f486ce943d27d8ec9782b389d6392e1234567897-004",
    "amount": "3435201159140",
    "gas": "0",
    "id": 0
}
```
