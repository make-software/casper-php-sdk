<?php

namespace Casper\Serializer;

use Casper\Entity\StoredValue;

class StoredValueEntitySerializer extends EntitySerializer
{
    /**
     * @param StoredValue $storedValue
     * @return array
     */
    public static function toJson($storedValue): array
    {
        if ($storedValue->getCLValue()) {
            $result['CLValue'] = CLValueEntitySerializer::toJson($storedValue->getCLValue());
        }

        if ($storedValue->getAccount()) {
            $result['Account'] = AccountEntitySerializer::toJson($storedValue->getAccount());
        }

        if ($storedValue->getContractWASM()) {
            $result['ContractWASM'] = $storedValue->getContractWASM();
        }

        if ($storedValue->getContract()) {
            $result['Contract'] = ContractMetadataEntitySerializer::toJson($storedValue->getContract());
        }

        if ($storedValue->getContractPackage()) {
            $result['ContractPackage'] = ContractPackageEntitySerializer::toJson($storedValue->getContractPackage());
        }

        if ($storedValue->getTransfer()) {
            $result['Transfer'] = TransferEntitySerializer::toJson($storedValue->getTransfer());
        }

        if ($storedValue->getDeployInfo()) {
            $result['DeployInfo'] = DeployInfoEntitySerializer::toJson($storedValue->getDeployInfo());
        }

        if ($storedValue->getEraInfo()) {
            $result['EraInfo'] = EraInfoEntitySerializer::toJson($storedValue->getEraInfo());
        }

        return $result ?? [];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): StoredValue
    {
        return new StoredValue(
            isset($json['CLValue']) ? CLValueEntitySerializer::fromJson($json['CLValue']) : null,
            isset($json['Account']) ? AccountEntitySerializer::fromJson($json['Account']) : null,
            $json['ContractWASM'] ?? null,
            isset($json['Contract']) ? ContractMetadataEntitySerializer::fromJson($json['Contract']) : null,
            isset($json['ContractPackage']) ? ContractPackageEntitySerializer::fromJson($json['ContractPackage']) : null,
            isset($json['Transfer']) ? TransferEntitySerializer::fromJson($json['Transfer']) : null,
            isset($json['DeployInfo']) ? DeployInfoEntitySerializer::fromJson($json['DeployInfo']) : null,
            isset($json['EraInfo']) ? EraInfoEntitySerializer::fromJson($json['EraInfo']) : null
        );
    }
}
