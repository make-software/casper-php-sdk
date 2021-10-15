<?php

namespace Casper\Serializer;

use Casper\Entity\DeployNamedArg;

class DeployNamedArgSerializer extends JsonSerializer
{
    /**
     * @param DeployNamedArg $deployNamedArg
     */
    public static function toJson($deployNamedArg): array
    {
        return array(
            $deployNamedArg->getName(),
            CLValueSerializer::toJson($deployNamedArg->getValue()),
        );
    }

    public static function fromJson(array $json): DeployNamedArg
    {
        return new DeployNamedArg(
            $json[0],
            CLValueSerializer::fromJson($json[1])
        );
    }
}
