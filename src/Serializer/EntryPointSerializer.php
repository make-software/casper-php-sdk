<?php

namespace Casper\Serializer;

use Casper\Entity\EntryPoint;

class EntryPointSerializer extends JsonSerializer
{
    /**
     * @param EntryPoint $entryPoint
     */
    public static function toJson($entryPoint): array
    {
        return array(
            'access' => $entryPoint->getAccess(),
            'entry_point_type' => $entryPoint->getEntryPointType(),
            'name' => $entryPoint->getName(),
            'ret' => $entryPoint->getRet()->toJson(),
            'args' => NamedCLTypeArgSerializer::toJsonArray($entryPoint->getArgs()),
        );
    }

    public static function fromJson(array $json): EntryPoint
    {
        return new EntryPoint(
            $json['access'],
            $json['entry_point_type'],
            $json['name'],
            CLTypeSerializer::fromJson($json['ret']),
            NamedCLTypeArgSerializer::fromJsonArray($json['args'])
        );
    }
}
