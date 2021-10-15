<?php

namespace Casper\Serializer;

use Casper\Entity\NamedCLTypeArg;

class NamedCLTypeArgSerializer extends JsonSerializer
{
    /**
     * @param NamedCLTypeArg $namedCLTypeArg
     */
    public static function toJson($namedCLTypeArg): array
    {
        return array(
            'name' => $namedCLTypeArg->getName(),
            'cl_type' => CLTypeSerializer::toJson($namedCLTypeArg->getClType())
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): NamedCLTypeArg
    {
        return new NamedCLTypeArg(
            $json['name'],
            CLTypeSerializer::fromJson(is_array($json['cl_type']) ? $json['cl_type'] : [$json['cl_type']])
        );
    }
}
