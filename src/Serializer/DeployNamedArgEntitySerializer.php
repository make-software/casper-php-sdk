<?php

namespace Casper\Serializer;

use Casper\Entity\DeployNamedArg;

class DeployNamedArgEntitySerializer extends EntitySerializer
{
    /**
     * @param DeployNamedArg $deployNamedArg
     * @return array
     */
    public static function toJson($deployNamedArg): array
    {
        return array(
            $deployNamedArg->getName(),
            CLValueEntitySerializer::toJson($deployNamedArg->getValue()),
        );
    }

    public static function fromJson(array $json): DeployNamedArg
    {
        return new DeployNamedArg(
            $json[0],
            CLValueEntitySerializer::fromJson($json[1])
        );
    }
}
