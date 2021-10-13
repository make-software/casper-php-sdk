<?php

namespace Casper\Serializer;

use Casper\Entity\DeployNamedArg;

class DeployNamedArgJsonSerializer extends JsonSerializer
{
    /**
     * @param DeployNamedArg $deployNamedArg
     */
    public static function toJson($deployNamedArg): array
    {
        return array(
            $deployNamedArg->getName(),
            CLValueJsonSerializer::toJson($deployNamedArg->getValue()),
        );
    }

    public static function fromJson(array $json): DeployNamedArg
    {
        return new DeployNamedArg(
            $json[0],
            CLValueJsonSerializer::fromJson($json[1])
        );
    }
}
