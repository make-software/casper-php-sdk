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

    public static function fromJson(array $json): StoredValue
    {
        return new StoredValue(
            isset($json['Account']) ? AccountSerializer::fromJson($json['Account']) : null
        );
    }
}
