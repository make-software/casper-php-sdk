<?php

namespace Casper\Serializer;

use Casper\Entity\NamedKey;

class NamedKeySerializer extends Serializer
{
    /**
     * @param NamedKey $namedKey
     * @return array
     */
    public static function toJson($namedKey): array
    {
        return array(
            'name' => $namedKey->getName(),
            'key' => $namedKey->getKey(),
        );
    }

    public static function fromJson(array $json): NamedKey
    {
        return new NamedKey(
            $json['name'],
            $json['key']
        );
    }
}
