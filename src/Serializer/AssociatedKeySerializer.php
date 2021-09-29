<?php

namespace Casper\Serializer;

use Casper\Entity\AssociatedKey;

class AssociatedKeySerializer extends Serializer
{

    /**
     * @param AssociatedKey $associatedKey
     * @return array
     */
    public static function toJson($associatedKey): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): AssociatedKey
    {
        return new AssociatedKey($json['account_hash'], $json['weight']);
    }
}
