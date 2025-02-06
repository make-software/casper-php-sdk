<?php

namespace Casper\Types\Serializer;

use Casper\Types\Operation;

class OperationSerializer extends JsonSerializer
{
    /**
     * @param Operation $operation
     */
    public static function toJson($operation): array
    {
        return array(
            'key' => $operation->getKey(),
            'kind' => $operation->getKind(),
        );
    }

    public static function fromJson(array $json): Operation
    {
        return new Operation($json['key'], $json['kind']);
    }
}
