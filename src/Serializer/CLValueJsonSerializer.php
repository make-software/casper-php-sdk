<?php

namespace Casper\Serializer;

use Casper\Util\ByteUtil;

use Casper\CLType\CLByteArray;
use Casper\CLType\CLByteArrayType;
use Casper\CLType\CLList;
use Casper\CLType\CLListType;
use Casper\CLType\CLMap;
use Casper\CLType\CLMapType;
use Casper\CLType\CLOption;
use Casper\CLType\CLResult;
use Casper\CLType\CLResultType;
use Casper\CLType\CLTuple1;
use Casper\CLType\CLTuple2;
use Casper\CLType\CLTuple3;
use Casper\CLType\CLValue;

class CLValueJsonSerializer extends JsonSerializer
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
        $classPrefix = 'Casper\CLType\CL';

        if (is_array($json['cl_type'])) {
            $typeName = array_key_first($json['cl_type']);
            $clValueClass = $classPrefix . $typeName;
            $clTypeParam = $json['cl_type'][$typeName];

            switch ($clValueClass) {
                case CLList::class:
                    $innerType = $classPrefix . $clTypeParam . 'Type';
                    $clType = new CLListType(new $innerType);
                    break;
                case CLByteArray::class:
                    $clType = new CLByteArrayType($clTypeParam);
                    break;
                case CLMap::class:
                    $keyTypeClass = $classPrefix . $clTypeParam['key'] . 'Type';
                    $valueType = $classPrefix . $clTypeParam['value'] . 'Type';
                    $clType = new CLMapType([new $keyTypeClass, new $valueType]);
                    break;
                case CLTuple1::class:
                case CLTuple2::class:
                case CLTuple3::class:
                    $clTypeClass = $clValueClass . 'Type';
                    $innerTypes = array_map(function (string $innerTypeName) use ($classPrefix) {
                        $innerTypeClass = $classPrefix . $innerTypeName . 'Type';
                        return new $innerTypeClass;
                    }, $clTypeParam);
                    $clType = new $clTypeClass($innerTypes);
                    break;
                case CLOption::class:
                    $clTypeClass = $classPrefix . $clTypeParam . 'Type';
                    $clType = new $clTypeClass;
                    break;
                case CLResult::class:
                    $innerTypeOk = $classPrefix . $clTypeParam['ok'] . 'Type';
                    $innerTypeErr = $classPrefix . $clTypeParam['err'] . 'Type';
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
