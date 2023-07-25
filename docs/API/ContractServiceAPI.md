# ContractService API

---
## Create Install deploy
```php
static createInstallDeploy(array $wasm, array $args, string $paymentAmount, CLPublicKey $sender, string $chainName, array $signingKeys): Deploy
```
Creates and returns new Install deploy object
### Parameters
| Name             | Type               | Description                | Required |
|------------------|--------------------|----------------------------|---|
| `$wasm`          | `array`            | Bytes array representation of a WebAssembly compiled smart contract           | Yes |
| `$args`          | `DeployNamedArg[]` | The runtime arguments for the installment deploy           | Yes |
| `$paymentAmount` | `string`           | The gas payment in motes, where 1 mote = 10^-9 CSPR             | Yes |
| `$sender`        | `CLPublicKey`      | CLPublicKey of the sender of the installment deploy | Yes |
| `$chainName`     | `string`           | The name of the network the installment deploy will be sent to | Yes |
| `$signingKeys`     | `AsymmetricKey[]`  | An array of keypairs used to sign the deploy. If you are signing with one key, use an array with only the one keypair. If instead you are utilizing multi-sig functionality, provide multiple keypair objects in the array | Yes |

---
## Install
```php
static install(RpcClient $rpcClient, array $wasm, array $args, string $paymentAmount, CLPublicKey $sender, string $chainName, array $signingKeys): string
```
Creates and put new Install deploy object into the network. Returns created deploy hash
### Parameters
| Name             | Type               | Description                                                                                                                                                                                                              | Required |
|------------------|--------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|---|
| `$rpcClient`          | `RpcClient`            | RpcClient instance                                                                                                                                                                                              | Yes |
| `$wasm`          | `array`            | Bytes array representation of a WebAssembly compiled smart contract                                                                                                                                                      | Yes |
| `$args`          | `DeployNamedArg[]` | The runtime arguments for the installment deploy                                                                                                                                                                         | Yes |
| `$paymentAmount` | `string`           | The gas payment in motes, where 1 mote = 10^-9 CSPR                                                                                                                                                                      | Yes |
| `$sender`        | `CLPublicKey`      | CLPublicKey of the sender of the installment deploy                                                                                                                                                                      | Yes |
| `$chainName`     | `string`           | The name of the network the installment deploy will be sent to                                                                                                                                                           | Yes |
| `$signingKeys`     | `AsymmetricKey[]`  | An array of keypairs used to sign the deploy. If you are signing with one key, use an array with only the one keypair. If instead you are utilizing multi-sig functionality, provide multiple keypair objects in the array | Yes |

---
## Constructor
```php
__constructor(Casper\Rpc\RpcClient $rpcClient, string $contractHash)
```
### Parameters
| Name | Type | Description                    | Required |
|---|---|--------------------------------|---|
| `$rpcClient` | `Casper\Rpc\RpcClient` | RpcClient instance             | Yes |
| `$contractHash` | `string` | Hex-encoded hash of a contract | Yes |

---
## Create CallEntryPoint deploy
```php
createCallEntryPointDeploy(string $entrypoint, array $args, string $paymentAmount, CLPublicKey $sender, string $chainName, array $signingKeys, int $ttl = DeployParams::DEFAULT_TTL): Deploy
```
Creates and returns CallEntryPoint deploy object
### Parameters
| Name             | Type               | Description                                                                                                                                                                                                                | Required |
|------------------|--------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------|
| `$entrypoint`    | `string`           | Name of an entrypoint of a smart contract that you wish to call                                                                                                                                                            | Yes      |
| `$args`          | `DeployNamedArg[]` | The runtime arguments for the installment deploy                                                                                                                                                                           | Yes      |
| `$paymentAmount` | `string`           | The gas payment in motes, where 1 mote = 10^-9 CSPR                                                                                                                                                                        | Yes      |
| `$sender`        | `CLPublicKey`      | CLPublicKey of the sender of the installment deploy                                                                                                                                                                        | Yes      |
| `$chainName`     | `string`           | The name of the network the installment deploy will be sent to                                                                                                                                                             | Yes      |
| `$signingKeys`   | `AsymmetricKey[]`  | An array of keypairs used to sign the deploy. If you are signing with one key, use an array with only the one keypair. If instead you are utilizing multi-sig functionality, provide multiple keypair objects in the array | Yes      |
| `$ttl`           | `int`              | The time that the deploy has to live. If the deploy awaits execution longer than this interval, in milliseconds, then the deploy will fail. The default value is 1800000, which is 30 minutes                                                                               | No       |

---
## Call entrypoint
```php
callEntryPoint(string $entrypoint, array $args, string $paymentAmount, CLPublicKey $sender, string $chainName, array $signingKeys, int $ttl = DeployParams::DEFAULT_TTL): string
```
Creates CallEntryPoint object and put created object into the network. Returns created deploy hash
### Parameters
| Name             | Type               | Description                                                                                                                                                                                                                | Required |
|------------------|--------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|---|
| `$entrypoint`          | `string`            | Name of an entrypoint of a smart contract that you wish to call                                                                                                                                                            | Yes |
| `$args`          | `DeployNamedArg[]` | The runtime arguments for the installment deploy                                                                                                                                                                           | Yes |
| `$paymentAmount` | `string`           | The gas payment in motes, where 1 mote = 10^-9 CSPR                                                                                                                                                                        | Yes |
| `$sender`        | `CLPublicKey`      | CLPublicKey of the sender of the installment deploy                                                                                                                                                                        | Yes |
| `$chainName`     | `string`           | The name of the network the installment deploy will be sent to                                                                                                                                                             | Yes |
| `$signingKeys`     | `AsymmetricKey[]`  | An array of keypairs used to sign the deploy. If you are signing with one key, use an array with only the one keypair. If instead you are utilizing multi-sig functionality, provide multiple keypair objects in the array | Yes |
| `$ttl`           | `int`              | The time that the deploy has to live. If the deploy awaits execution longer than this interval, in milliseconds, then the deploy will fail. The default value is 1800000, which is 30 minutes                                                                               | No       |
