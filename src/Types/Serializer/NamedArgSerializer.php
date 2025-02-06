<?php

namespace Casper\Types\Serializer;

use Casper\Types\NamedArg;

class NamedArgSerializer extends JsonSerializer
{
    /**
     * @param NamedArg $deployNamedArg
     */
    public static function toJson($deployNamedArg): array
    {
        return array(
            $deployNamedArg->getName(),
            CLValueSerializer::toJson($deployNamedArg->getValue()),
        );
    }

    public static function fromJson(array $json): NamedArg
    {
        return new NamedArg(
            $json[0],
            CLValueSerializer::fromJson($json[1])
        );
    }
}
