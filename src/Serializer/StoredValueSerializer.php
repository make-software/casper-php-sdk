<?php

namespace Casper\Serializer;

use Casper\Entity\StoredValue;

class StoredValueSerializer extends Serializer
{
    /**
     * @param StoredValue $storedValue
     * @return array
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
            isset($json['CLValue']) ? CLValueSerializer::fromJson($json['CLValue']) : null,
            isset($json['Account']) ? AccountSerializer::fromJson($json['Account']) : null,
            $json['ContractWASM'] ?? null,
            isset($json['EraInfo']) ? EraInfoSerializer::fromJson($json['EraInfo']) : null
        );
    }
}
