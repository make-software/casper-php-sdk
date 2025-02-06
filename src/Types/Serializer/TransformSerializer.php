<?php

namespace Casper\Types\Serializer;

use Casper\Types\Transform;

class TransformSerializer extends JsonSerializer
{
    /**
     * @param Transform $transform
     */
    public static function toJson($transform): array
    {
        return array(
            'key' => $transform->getKey(),
            'kind' => $transform->getKind(),
        );
    }

    public static function fromJson(array $json): Transform
    {
        return new Transform($json['key'], $json['kind']);
    }
}
