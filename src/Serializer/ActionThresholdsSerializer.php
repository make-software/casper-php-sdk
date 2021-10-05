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
        return array(
            'deployment' => $actionThresholds->getDeployment(),
            'key_management' => $actionThresholds->getKeyManagement(),
        );
    }

    public static function fromJson(array $json): ActionThresholds
    {
        return new ActionThresholds($json['deployment'], $json['key_management']);
    }
}
