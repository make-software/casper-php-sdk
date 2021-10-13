<?php

namespace Casper\Serializer;

use Casper\Entity\NamedCLTypeArg;

class NamedCLTypeArgJsonSerializer extends JsonSerializer
{
    /**
     * @param NamedCLTypeArg $namedCLTypeArg
     */
    public static function toJson($namedCLTypeArg): array
    {
        return array(
            'name' => $namedCLTypeArg->getName(),
            'cl_type' => CLTypeJsonSerializer::toJson($namedCLTypeArg->getClType())
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): NamedCLTypeArg
    {
        return new NamedCLTypeArg(
            $json['name'],
            CLTypeJsonSerializer::fromJson(is_array($json['cl_type']) ? $json['cl_type'] : [$json['cl_type']])
        );
    }
}
