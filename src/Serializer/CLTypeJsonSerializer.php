<?php

namespace Casper\Serializer;

use Casper\Util\ArrayUtil;

use Casper\CLType\CLByteArrayType;
use Casper\CLType\CLListType;
use Casper\CLType\CLMapType;
use Casper\CLType\CLOptionType;
use Casper\CLType\CLResultType;
use Casper\CLType\CLTuple1Type;
use Casper\CLType\CLTuple2Type;
use Casper\CLType\CLTuple3Type;
use Casper\CLType\CLType;

class CLTypeJsonSerializer extends JsonSerializer
{
    /**
     * @param CLType $clType
     */
    public static function toJson($clType): array
    {
        return $clType->toJson();
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): CLType
    {
        $classPrefix = 'Casper\CLType\CL';

        if (ArrayUtil::isMap($json)) {
            $typeName = array_key_first($json);
            $clTypeClass = $classPrefix . $typeName . 'Type';
            $clTypeParam = $json[$typeName];

            switch ($clTypeClass) {
                case CLListType::class:
                    $innerType = $classPrefix . $clTypeParam . 'Type';
                    $clType = new $clTypeClass(new $innerType());
                    break;
                case CLByteArrayType::class:
                    $clType = new $clTypeClass($clTypeParam);
                    break;
                case CLMapType::class:
                    $keyTypeClass = $classPrefix . $clTypeParam['key'] . 'Type';
                    $valueType = $classPrefix . $clTypeParam['value'] . 'Type';
                    $clType = new $clTypeClass([new $keyTypeClass, new $valueType]);
                    break;
                case CLTuple1Type::class:
                case CLTuple2Type::class:
                case CLTuple3Type::class:
                    $clTypeClass = $clTypeClass . 'Type';
                    $innerTypes = array_map(function (string $innerTypeName) use ($classPrefix) {
                        $innerTypeClass = $classPrefix . $innerTypeName . 'Type';
                        return new $innerTypeClass;
                    }, $clTypeParam);
                    $clType = new $clTypeClass($innerTypes);
                    break;
                case CLOptionType::class:
                    $innerTypeClass = $classPrefix . $clTypeParam . 'Type';
                    $clType = new $clTypeClass(new $innerTypeClass());
                    break;
                case CLResultType::class:
                    $innerTypeOk = $classPrefix . $clTypeParam['ok'] . 'Type';
                    $innerTypeErr = $classPrefix . $clTypeParam['err'] . 'Type';
                    $clType = $clTypeClass(new $innerTypeOk, new $innerTypeErr);
                    break;
                default:
                    throw new \Exception('The complex type ' . $clTypeClass . 'Type' . ' is not supported');
            }
        }
        else {
            $clTypeClass = $classPrefix . $json[0] . 'Type';
            $clType = new $clTypeClass();
        }

        return $clType;
    }
}
