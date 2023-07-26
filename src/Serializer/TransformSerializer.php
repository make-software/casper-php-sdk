<?php

namespace Casper\Serializer;

use Casper\Entity\Transform;

class TransformSerializer extends JsonSerializer
{
    /**
     * @param Transform $transform
     */
    public static function toJson($transform): array
    {
        return array(
            'key' => $transform->getKey(),
            'transform' => $transform->getTransform(),
        );
    }

    public static function fromJson(array $json): Transform
    {
        return new Transform($json['key'], $json['transform']);
    }
}
