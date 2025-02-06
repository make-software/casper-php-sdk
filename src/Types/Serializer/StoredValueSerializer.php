<?php

namespace Casper\Types\Serializer;

use Casper\Types\StoredValue;

class StoredValueSerializer extends JsonSerializer
{
    /**
     * @param StoredValue $storedValue
     */
    public static function toJson($storedValue): array
    {
        if ($storedValue->getCLValue()) {
            $result['CLValue'] = CLValueSerializer::toJson($storedValue->getCLValue());
        }

        if ($storedValue->getAccount()) {
            $result['Account'] = AccountSerializer::toJson($storedValue->getAccount());
        }

        if ($storedValue->getContractWASM()) {
            $result['ContractWASM'] = $storedValue->getContractWASM();
        }

        if ($storedValue->getContract()) {
            $result['Contract'] = ContractSerializer::toJson($storedValue->getContract());
        }

        if ($storedValue->getContractPackage()) {
            $result['ContractPackage'] = ContractPackageSerializer::toJson($storedValue->getContractPackage());
        }

        if ($storedValue->getTransfer()) {
            $result['Transfer'] = TransferSerializer::toJson($storedValue->getTransfer());
        }

        if ($storedValue->getDeployInfo()) {
            $result['DeployInfo'] = DeployInfoSerializer::toJson($storedValue->getDeployInfo());
        }

        if ($storedValue->getEraInfo()) {
            $result['EraInfo'] = EraInfoSerializer::toJson($storedValue->getEraInfo());
        }

        return $result ?? [];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): StoredValue
    {
        return new StoredValue(
            isset($json['CLValue']) ? CLValueSerializer::fromJson($json['CLValue']) : null,
            isset($json['Account']) ? AccountSerializer::fromJson($json['Account']) : null,
            $json['ContractWASM'] ?? null,
            isset($json['Contract']) ? ContractSerializer::fromJson($json['Contract']) : null,
            isset($json['ContractPackage']) ? ContractPackageSerializer::fromJson($json['ContractPackage']) : null,
            isset($json['Transfer']) ? TransferSerializer::fromJson($json['Transfer']) : null,
            isset($json['DeployInfo']) ? DeployInfoSerializer::fromJson($json['DeployInfo']) : null,
            isset($json['EraInfo']) ? EraInfoSerializer::fromJson($json['EraInfo']) : null
        );
    }
}
