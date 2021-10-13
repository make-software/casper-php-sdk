<?php

namespace Casper\Serializer;

use Casper\Entity\EntryPoint;

class EntryPointJsonSerializer extends JsonSerializer
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
            'args' => NamedCLTypeArgJsonSerializer::toJsonArray($entryPoint->getArgs()),
        );
    }

    public static function fromJson(array $json): EntryPoint
    {
        return new EntryPoint(
            $json['access'],
            $json['entry_point_type'],
            $json['name'],
            CLTypeJsonSerializer::fromJson($json['ret']),
            NamedCLTypeArgJsonSerializer::fromJsonArray($json['args'])
        );
    }
}
