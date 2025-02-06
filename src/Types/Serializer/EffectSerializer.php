<?php

namespace Casper\Types\Serializer;

use Casper\Types\Effect;

class EffectSerializer extends JsonSerializer
{
    /**
     * @param Effect $effect
     */
    public static function toJson($effect): array
    {
        return array(
            'operations' => OperationSerializer::toJsonArray($effect->getOperations()),
            'transforms' => TransformSerializer::toJsonArray($effect->getTransforms()),
        );
    }

    public static function fromJson(array $json): Effect
    {
        return new Effect(
            OperationSerializer::fromJsonArray($json['operations']),
            TransformSerializer::fromJsonArray($json['transforms'])
        );
    }
}
