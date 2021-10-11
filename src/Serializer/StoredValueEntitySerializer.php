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

        if ($storedValue->getEraInfo()) {
            $result['EraInfo'] = $storedValue->getEraInfo();
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
            isset($json['EraInfo']) ? EraInfoEntitySerializer::fromJson($json['EraInfo']) : null
        );
    }
}
