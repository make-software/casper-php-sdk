# Deploy

Deploy represents a request from a user to perform computation on casper platform. It has the following information:

- Deploy hash: the blake2b256 hash of the Header
- Header: containing
  - the identity key of the account the deploy will run in
  - the timestamp when the deploy was created
  - a time to live, after which the deploy is expired and cannot be included in a block
  - the blake2b256 hash of the body
- Body: containing payment code and session code
- Approvals: the set of signatures which have signed the deploy hash, these are used in the account permissions model

Each deploy is an atomic piece of computation in the sense that, whatever effects a deploy would have on the global state must be entirely included in a block or the entire deploy must not be included in a block.

---
```php
getHash(): array
```
Returns a deploy hash byte array

---
```php
getHeader(): DeployHeader
```
Returns [DeployHeader](DeployHeader.md) object

---
```php
getPayment(): DeployExecutable
```
Returns [DeployExecutable](DeployExecutable.md) object that representing a deploy payment

---
```php
isStandardPayment(): bool
```
Returns `true` if deploy payment is standard payment

---
```php
getSession(): DeployExecutable
```
Returns [DeployExecutable](DeployExecutable.md) object that representing a deploy session

---
```php
isTransfer(): bool
```
Returns `true` if a deploy session is transfer

---
```php
getApprovals(): array
```
Return a list of [DeployApproval](DeployApproval.md) objects

---
```php
pushApproval(DeployApproval $approval): self
```
Push [DeployApproval](DeployApproval.md) to deploy and returns `self` object
##### Parameters

| Name | Type | Description | Required |
|---|---|---|---|
| `$approval`| `DeployApproval` | [DeployApproval](DeployApproval.md) object | Yes |

## JSON Representation
Below is an example of a deploy JSON returned by node RPC API
```json
{
    "hash": "c1234567894c930b5d181d7ad3ebb07ecd38d732d10c90ceef44de16d3ac8e1f",
    "header": {
        "account": "01112123456789880b663120990bada942107b8dd0f179a0d665310d4e527117a1",
        "timestamp": "2021-01-01T00:00:00.000Z",
        "ttl": "30m",
        "gas_price": 1,
        "body_hash": "cf3f31234567899c732a76dc7c519d474d42d80cbdbb7bef6d501fa2d80f9c95",
        "dependencies": [],
        "chain_name": "casper"
    },
    "payment": {
        "ModuleBytes": {
            "module_bytes": "",
            "args": [
                [
                    "amount",
                    {
                        "cl_type": "U512",
                        "bytes": "021027",
                        "parsed": "10000"
                    }
                ]
            ]
        }
    },
    "session": {
        "Transfer": {
            "args": [
                [
                    "amount",
                    {
                        "cl_type": "U512",
                        "bytes": "06f08096ef582d",
                        "parsed": "49859999990000"
                    }
                ],
                [
                    "target",
                    {
                        "cl_type": {
                            "ByteArray": 32
                        },
                        "bytes": "c62a112345678934b388cd3070a2039b315390ebe77fbf3b12e30c61470a17b9",
                        "parsed": "c62a1908e528c734b388cd3070a2039123456789e77fbf3b12e30c61470a17b9"
                    }
                ],
                [
                    "id",
                    {
                        "cl_type": {
                            "Option": "U64"
                        },
                        "bytes": "010100000000000000",
                        "parsed": 1
                    }
                ]
            ]
        }
    },
    "approvals": [
        {
            "signer": "011125a8ec21234567893120990bada942107b8dd0f179a0d665310d4e527117a1",
            "signature": "01041ccca62700ce75b55f123456789301444893c0a2f379950a8a942d91ec0ee14f00d0bcb38703a4908adcb3076757b5f88f6c54d491c9caa4a96f310f8b1408"
        }
    ]
}
```
