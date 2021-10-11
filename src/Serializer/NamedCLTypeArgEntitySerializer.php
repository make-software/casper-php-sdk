<?php

namespace Casper\Serializer;

use Casper\Entity\NamedCLTypeArg;

class NamedCLTypeArgEntitySerializer extends EntitySerializer
{
    /**
     * @param NamedCLTypeArg $namedCLTypeArg
     * @return array
     */
    public static function toJson($namedCLTypeArg): array
    {
        return array(
            'name' => $namedCLTypeArg->getName(),
            'cl_type' => CLTypeEntitySerializer::toJson($namedCLTypeArg->getClType())
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): NamedCLTypeArg
    {
        return new NamedCLTypeArg(
            $json['name'],
            CLTypeEntitySerializer::fromJson(is_array($json['cl_type']) ? $json['cl_type'] : [$json['cl_type']])
        );
    }
}
