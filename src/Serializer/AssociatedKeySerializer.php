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
        return array(
            'account_hash' => $associatedKey->getAccountHash(),
            'weight' => $associatedKey->getWeight(),
        );
    }

    public static function fromJson(array $json): AssociatedKey
    {
        return new AssociatedKey($json['account_hash'], $json['weight']);
    }
}
