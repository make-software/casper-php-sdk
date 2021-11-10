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
Returns list of [EraValidator](EraValidator.md) objects for the current era and the next era

---
```php
getBids(): array
```
Returns list of [Bid](Bid.md) objects

## JSON Representation
Below is an example of auction state JSON returned by node RPC API
```json
{
    "state_root_hash": "11c87261f5f00de726cc1f8bd6c263051b931e29727817e49e346aa9e314dc84",
    "block_height": 300000,
    "era_validators": [
        {
            "era_id": 3000,
            "validator_weights": [
                {
                    "public_key": "01abc681d910a8ac877b81537d75db42395b9da0da1a3457d223151305f803da0e",
                    "weight": "400000000000"
                },
                {
                    "public_key": "01faa681d910a8ac877b81537d75db42395b9da0da1a3457d223151305f803da0e",
                    "weight": "500000000000"
                }
            ]
        },
        {
            "era_id": 3001,
            "validator_weights": [
                {
                    "public_key": "01026ca707c348ed8012ac6a1f28db031faddceb6720350aa3533867108c8a9a80",
                    "weight": "600000000000"
                },
                {
                    "public_key": "01faa681d910a8ac877a81537c75db42395b9da0da1a3457d223151305f803da0e",
                    "weight": "700000000000"
                }
            ]
        }
    ],
    "bids": [
        {
            "public_key": "0134567890c348ed8012ac6a1f28db031fadd6eb67203501a353b867a08c8b9a80",
            "bid": {
                "bonding_purse": "uref-1234567892abcb30f99fd0c5a5f39b2211317ebe645736e32a56e014c20a4514-007",
                "staked_amount": "1595867826655298",
                "delegation_rate": 30,
                "delegators": [
                    {
                        "public_key": "0112345678987a4e132ba2444c0350698e397952aa86f3248e61fb0cfc15ac527b",
                        "staked_amount": "34505297620074982",
                        "bonding_purse": "uref-575d1234567894f39e88c56f3684965b82a5c79e14df8d5fbe74a62962de0bb5-007",
                        "delegatee": "01026123456789ed8012ac6a1f28db031fadd6eb67203501a353b867a08c8b9a80"
                    },
                    {
                        "public_key": "011fc88f8f9084f2a612345678950d97d523403ca9aef611a4028e3c26ba208c7e",
                        "staked_amount": "152597712327",
                        "bonding_purse": "uref-12a28c8a746ae39ac5826a5f7738fa2c9cdd9c49cda794db629427d39f36eb31-007",
                        "delegatee": "01026ca707c341234567896a1f28db031fadd6eb67203501a353b867a08c8b9a80"
                    }
                ],
                "inactive": false
            }
        },
        {
            "public_key": "01faec72d1381234567890d9ba1f6a05c5fabaa98da8bb41c8c92041d2f58337d2",
            "bid": {
                "bonding_purse": "uref-9611297ccf8f123456789e462f6356d7ae1e484a1f852fbbfdea3b4117b85fb0-007",
                "staked_amount": "68490715353924",
                "delegation_rate": 10,
                "delegators": [
                    {
                        "public_key": "015f065acdce123456789125a3325565b28f702509d3d09bae001cee972a66d53a",
                        "staked_amount": "2874635051551640",
                        "bonding_purse": "uref-7aac5a12345678971c8af938035511ea40df5add8488956cae71009b38b6fdd4-007",
                        "delegatee": "01faec72d138026edbd4712345678905c5fabaa98da8bb41c8c92041d2f58337d2"
                    },
                    {
                        "public_key": "01c6ccb3a919a22de1234567898944148948dc08f5cfe3479448b74cc7756b2925",
                        "staked_amount": "20075317748510",
                        "bonding_purse": "uref-c239e161512345678960cf5c0ba3657605da3c9e4a5002f876070dcbe7a1117c-007",
                        "delegatee": "01faec72d138026edbd1234567896a05c5fabaa98da8bb41c8c92041d2f58337d2"
                    }
                ],
                "inactive": true
            }
        }
    ]
}
```
