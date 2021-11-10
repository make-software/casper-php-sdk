# Block

```php
getHash(): string
```
Returns hex-encoded hash string

---
```php
getHeader(): BlockHeader
```
Returns [BlockHeader](BlockHeader.md) object

---
```php
getBody(): BlockBody
```
Returns [BlockBody](BlockBody.md) object

---
```php
getProofs(): array
```
Returns list of [BlockProof](BlockProof.md) objects

## JSON Representation
```json
{
    "hash": "8cc1234567899f187b9b92ac07d9546d61b0344673ea8760f2a5982a4f68c768",
    "header": {
        "parent_hash": "4bf41234567899cce0b6b579dd50578761951a3ccb5f7b6d8adc775473dc36c2",
        "state_root_hash": "261234567890660450e02905416e02e633f70ecfd03be49dd811085056be9058",
        "body_hash": "99ba75123456789ae7c95e14a9583310a69cdd9a6e7a8efd63638ec8ef93bd09",
        "random_bit": true,
        "accumulated_seed": "058db123456789fb9dbe02dbecf373e65b766b824ea4d2aa07d043e7497f8d01",
        "era_end": null,
        "timestamp": "2021-01-01T00:00:00.840Z",
        "era_id": 2000,
        "height": 234567,
        "protocol_version": "1.3.4"
    },
    "body": {
        "proposer": "018f123456789284f189cc8cb49f89212ff434a5eb050e48cdd164ff3890fbff69",
        "deploy_hashes": [],
        "transfer_hashes": [
            "8f554cad7121123456789a6fde2dcc3bf696327b4afabf160057b551df393767"
        ]
    },
    "proofs": [
        {
            "public_key": "01f8d6612345678936f3d0204f01f22aeb11be9f1d87f474b3368f95ec8a1f77dd",
            "signature": "01519f11234567895cad0ec054e3dfa472e34d200ee4078b774ceac009cbb9555878cea513c3e2b022ee3ad7f0ee5624f919889df4f8881bb83f9992163adec401"
        },
        {
            "public_key": "01faec7123456789dbd470d9ba1f6a05c5fabaa98da8bb41c8c92041d2f58337d2",
            "signature": "01f98ef117579ecdce13901e9ef5ac123456789cf3ea3d4e77e9507f9992d83e487b93e1fd8fc418cf4537866d2742ebcbd1e830a97693b3ab7da981f80b06"
        }
    ]
}
```
