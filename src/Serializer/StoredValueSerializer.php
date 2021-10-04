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
        // TODO: Implement toJson() method.
        return [];
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
