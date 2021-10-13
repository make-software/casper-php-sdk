<?php

namespace Casper\Serializer;

use Casper\Entity\AssociatedKey;

class AssociatedKeyJsonSerializer extends JsonSerializer
{
    /**
     * @param AssociatedKey $associatedKey
     */
    public static function toJson($associatedKey): array
    {
        return array(
            'account_hash' => CLAccountHashStringSerializer::toString($associatedKey->getAccountHash()),
            'weight' => $associatedKey->getWeight(),
        );
    }

    public static function fromJson(array $json): AssociatedKey
    {
        return new AssociatedKey(
            CLAccountHashStringSerializer::fromString($json['account_hash']),
            $json['weight']
        );
    }
}
