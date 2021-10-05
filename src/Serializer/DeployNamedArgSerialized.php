<?php

namespace Casper\Serializer;

use Casper\Entity\DeployNamedArg;
use Casper\Util\ByteUtil;

class DeployNamedArgSerialized extends Serializer
{
    /**
     * @param DeployNamedArg $deployNamedArg
     * @return array
     */
    public static function toJson($deployNamedArg): array
    {
        return array(
            $deployNamedArg->getName(),
            array(
                'cl_type' => $deployNamedArg->getValue()->clType()->toJson(),
                'bytes' => ByteUtil::byteArrayToHex($deployNamedArg->getValue()->toBytes()),
                'parsed' => $deployNamedArg->getValue()->parsedValue(),
            )
        );
    }

    public static function fromJson(array $json): DeployNamedArg
    {
        return new DeployNamedArg($json[0], CLValueSerializer::fromJson($json[1]));
    }
}
