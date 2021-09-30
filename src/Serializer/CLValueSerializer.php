<?php

namespace Casper\Serializer;

use Casper\Util\ByteUtil;

use Casper\CLType\CLByteArray;
use Casper\CLType\CLByteArrayType;
use Casper\CLType\CLOption;
use Casper\CLType\CLValue;

class CLValueSerializer extends Serializer
{
    /**
     * @param CLValue $clValue
     * @return array
     */
    public static function toJson($clValue): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): CLValue
    {
        $clClassNameSpace = 'Casper\CLType';

        if (is_array($json['cl_type'])) {
            $clValueClass = $clClassNameSpace . '\CL' . array_key_first($json['cl_type']);
            $clTypeParam = $json['cl_type'][array_key_first($json['cl_type'])];

            //TODO: Add all types
            switch ($clValueClass) {
                case CLByteArray::class:
                    $clType = new CLByteArrayType($clTypeParam);
                    break;
                case CLOption::class:
                    $clTypeClass = $clClassNameSpace . '\CL' . $clTypeParam . 'Type';
                    $clType = new $clTypeClass;
                    break;
                default:
                    throw new \Exception('The complex type ' . $clValueClass . 'Type' . ' is not supported');
            }
        }
        else {
            $clValueClass = $clClassNameSpace . '\CL' . $json['cl_type'];
        }

        return $clValueClass::fromBytes(
            ByteUtil::hexToByteArray($json['bytes']),
            $clType ?? null
        );
    }
}
