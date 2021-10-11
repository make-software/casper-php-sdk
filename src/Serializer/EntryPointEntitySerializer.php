<?php

namespace Casper\Serializer;

use Casper\Entity\EntryPoint;

class EntryPointEntitySerializer extends EntitySerializer
{
    /**
     * @param EntryPoint $entryPoint
     * @return array
     */
    public static function toJson($entryPoint): array
    {
        return array(
            'access' => $entryPoint->getAccess(),
            'entry_point_type' => $entryPoint->getEntryPointType(),
            'name' => $entryPoint->getName(),
            'ret' => $entryPoint->getRet(),
            'args' => NamedCLTypeArgEntitySerializer::toJsonArray($entryPoint->getArgs()),
        );
    }

    public static function fromJson(array $json): EntryPoint
    {
        return new EntryPoint(
            $json['access'],
            $json['entry_point_type'],
            $json['name'],
            $json['ret'],
            NamedCLTypeArgEntitySerializer::fromJsonArray($json['args'])
        );
    }
}
