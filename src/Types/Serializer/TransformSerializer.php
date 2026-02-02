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
        $key = $json['key'] ?? '';
        $kind = $json['kind'] ?? ($json['transform'] ?? ($json['value'] ?? null));

        return new Transform($key, $kind);
    }
}
