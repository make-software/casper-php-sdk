<?php

namespace Casper\Serializer;

use Casper\Entity\ActionThresholds;

class ActionThresholdsSerializer extends Serializer
{
    /**
     * @param ActionThresholds $actionThresholds
     * @return array
     */
    public static function toJson($actionThresholds): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): ActionThresholds
    {
        return new ActionThresholds($json['deployment'], $json['key_management']);
    }
}
