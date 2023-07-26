# Status

```php
getApiVersion(): string
```
Returns node's RPC API version

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

---
```php
getUptime(): string
```
Returns time that passed since the node has started.

---
```php
getReactorState(): string
```
Returns node's reactor state

---
```php
getLastProgress(): \DateTime
```
Returns node's last progress

---
```php
getLastProgress(): BlockRange
```
Returns [BlockRange](BlockRange.md) object
