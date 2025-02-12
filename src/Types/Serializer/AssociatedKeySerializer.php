<?php

namespace Casper\Types\Serializer;

use Casper\Types\AssociatedKey;
use Casper\Types\CLValue\CLAccountHash;

class AssociatedKeySerializer extends JsonSerializer
{
    /**
     * @param AssociatedKey $associatedKey
     */
    public static function toJson($associatedKey): array
    {
        return array(
            'account_hash' => $associatedKey->getAccountHash()->parsedValue(),
            'weight' => $associatedKey->getWeight(),
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): AssociatedKey
    {
        return new AssociatedKey(
            CLAccountHash::fromString($json['account_hash']),
            $json['weight']
        );
    }
}
