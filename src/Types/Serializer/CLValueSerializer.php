<?php

namespace Casper\Types\Serializer;

use Casper\Util\ByteUtil;

use Casper\Types\CLValue\CLType\CLByteArrayType;
use Casper\Types\CLValue\CLType\CLListType;
use Casper\Types\CLValue\CLType\CLMapType;
use Casper\Types\CLValue\CLType\CLResultType;

use Casper\Types\CLValue\CLByteArray;
use Casper\Types\CLValue\CLList;
use Casper\Types\CLValue\CLMap;
use Casper\Types\CLValue\CLOption;
use Casper\Types\CLValue\CLResult;
use Casper\Types\CLValue\CLTuple1;
use Casper\Types\CLValue\CLTuple2;
use Casper\Types\CLValue\CLTuple3;
use Casper\Types\CLValue\CLValue;

class CLValueSerializer extends JsonSerializer
{
    /**
     * @param CLValue $clValue
     */
    public static function toJson($clValue): array
    {
        return array(
            'cl_type' => $clValue->clType()->toJson(),
            'bytes' => ByteUtil::byteArrayToHex($clValue->toBytes()),
            'parsed' => $clValue->parsedValue(),
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): CLValue
    {
        $classPrefix = 'Casper\Types\CLValue\CL';

        if (is_array($json['cl_type'])) {
            $typeName = array_key_first($json['cl_type']);
            $clValueClass = $classPrefix . $typeName;
            $clTypeParam = $json['cl_type'][$typeName];

            switch ($clValueClass) {
                case CLList::class:
                    $innerType = $classPrefix . 'Type\CL' . $clTypeParam . 'Type';
                    $clType = new CLListType(new $innerType);
                    break;
                case CLByteArray::class:
                    $clType = new CLByteArrayType($clTypeParam);
                    break;
                case CLMap::class:
                    $keyTypeClass = $classPrefix . 'Type\CL' . $clTypeParam['key'] . 'Type';
                    $valueType = $classPrefix . 'Type\CL' . $clTypeParam['value'] . 'Type';
                    $clType = new CLMapType([new $keyTypeClass, new $valueType]);
                    break;
                case CLTuple1::class:
                case CLTuple2::class:
                case CLTuple3::class:
                    $clTypeClass = $clValueClass . 'Type';
                    $innerTypes = array_map(function (string $innerTypeName) use ($classPrefix) {
                        $innerTypeClass = $classPrefix . 'Type\CL' . $innerTypeName . 'Type';
                        return new $innerTypeClass;
                    }, $clTypeParam);
                    $clType = new $clTypeClass($innerTypes);
                    break;
                case CLOption::class:
                    $clTypeClass = $classPrefix . 'Type\CL' . $clTypeParam . 'Type';
                    $clType = new $clTypeClass;
                    break;
                case CLResult::class:
                    $innerTypeOk = $classPrefix . 'Type\CL' . $clTypeParam['ok'] . 'Type';
                    $innerTypeErr = $classPrefix . 'Type\CL' . $clTypeParam['err'] . 'Type';
                    $clType = new CLResultType(new $innerTypeOk, new $innerTypeErr);
                    break;
                default:
                    throw new \Exception('The complex type ' . $clValueClass . 'Type' . ' is not supported');
            }
        }
        else {
            $clValueClass = $classPrefix . $json['cl_type'];
        }

        return $clValueClass::fromBytes(
            ByteUtil::hexToByteArray($json['bytes']),
            $clType ?? null
        );
    }
}
