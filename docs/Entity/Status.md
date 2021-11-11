# Status

```php
getChainspecName(): string
```
Returns the chainspec name

---
```php
getStartingStateRootHash(): string
```
Returns starting state root hash

---
```php
getLastAddedBlockInfo(): BlockInfo
```
Returns [BlockInfo](BlockInfo.md) object

---
```php
getOurPublicSigningKey(): CLPublicKey
```
Returns `CLPublicKey` object

---
```php
getRoundLength(): ?int
```
Returns the next round length if this node is a validator

---
```php
getBuildVersion(): string
```
Returns compiled node version

---
```php
getNextUpgrade(): ?NextUpgrade
```
Returns [NextUpgrade](NextUpgrade.md) object or `null`

---
```php
getPeers(): array
```
Returns a list of [Peer](Peer.md) objects that connected to the network
