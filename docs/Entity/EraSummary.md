# EraSummary

```php
getBlockHash(): string
```
Returns hex-encoded block hash string

---
```php
getEraId(): int
```
Returns era id

---
```php
getStoredValue(): StoredValue
```
Returns [StoredValue](StoredValue.md) object that contains era information

---
```php
getStateRootHash(): string
```
Returns global state hex-encoded hash string

## JSON Representation
Below is an example of era summary JSON returned by node RPC API
```json
{
    "block_hash": "ca0b462123456789b54ac508901225591105c0f2bf888086e1e906059382c582",
    "era_id": 1,
    "stored_value": {
        "EraInfo": {
            "seigniorage_allocations": [
                {
                    "Delegator": {
                        "delegator_public_key": "01128d123456789df535cf3a763996344ab0cc79038faaee0aaaf098a078031ce6",
                        "validator_public_key": "01026ca1234567898012ac6a1f28db031fadd6eb67203501a353b867a08c8b9a80",
                        "amount": "87531943693"
                    }
                },
                {
                    "Validator": {
                        "validator_public_key": "01faec7123456789dbd470d9ba1f6a05c5fabaa98da8bb41c8c92041d2f58337d2",
                        "amount": "42983333146"
                    }
                }
            ]
        }
    },
    "state_root_hash": "479fc21c13e7f123456789c2b366ef2c2c8b47efe90a2208292a7f8058470b4e",
}
```
