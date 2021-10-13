<?php

namespace Casper\Serializer;

use Casper\Entity\StoredValue;

class StoredValueJsonSerializer extends JsonSerializer
{
    /**
     * @param StoredValue $storedValue
     */
    public static function toJson($storedValue): array
    {
        if ($storedValue->getCLValue()) {
            $result['CLValue'] = CLValueJsonSerializer::toJson($storedValue->getCLValue());
        }

        if ($storedValue->getAccount()) {
            $result['Account'] = AccountJsonSerializer::toJson($storedValue->getAccount());
        }

        if ($storedValue->getContractWASM()) {
            $result['ContractWASM'] = $storedValue->getContractWASM();
        }

        if ($storedValue->getContract()) {
            $result['Contract'] = ContractJsonSerializer::toJson($storedValue->getContract());
        }

        if ($storedValue->getContractPackage()) {
            $result['ContractPackage'] = ContractPackageJsonSerializer::toJson($storedValue->getContractPackage());
        }

        if ($storedValue->getTransfer()) {
            $result['Transfer'] = TransferJsonSerializer::toJson($storedValue->getTransfer());
        }

        if ($storedValue->getDeployInfo()) {
            $result['DeployInfo'] = DeployInfoJsonSerializer::toJson($storedValue->getDeployInfo());
        }

        if ($storedValue->getEraInfo()) {
            $result['EraInfo'] = EraInfoJsonSerializer::toJson($storedValue->getEraInfo());
        }

        return $result ?? [];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): StoredValue
    {
        return new StoredValue(
            isset($json['CLValue']) ? CLValueJsonSerializer::fromJson($json['CLValue']) : null,
            isset($json['Account']) ? AccountJsonSerializer::fromJson($json['Account']) : null,
            $json['ContractWASM'] ?? null,
            isset($json['Contract']) ? ContractJsonSerializer::fromJson($json['Contract']) : null,
            isset($json['ContractPackage']) ? ContractPackageJsonSerializer::fromJson($json['ContractPackage']) : null,
            isset($json['Transfer']) ? TransferJsonSerializer::fromJson($json['Transfer']) : null,
            isset($json['DeployInfo']) ? DeployInfoJsonSerializer::fromJson($json['DeployInfo']) : null,
            isset($json['EraInfo']) ? EraInfoJsonSerializer::fromJson($json['EraInfo']) : null
        );
    }
}
