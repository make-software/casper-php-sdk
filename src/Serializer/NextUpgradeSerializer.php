<?php

namespace Casper\Serializer;

use Casper\Entity\NextUpgrade;

class NextUpgradeSerializer extends JsonSerializer
{
    /**
     * @param NextUpgrade $nextUpgrade
     */
    public static function toJson($nextUpgrade): array
    {
        return array(
            'activation_point' => $nextUpgrade->getActivationPoint(),
            'protocol_version' => $nextUpgrade->getProtocolVersion(),
        );
    }

    public static function fromJson(array $json): NextUpgrade
    {
        return new NextUpgrade(
            $json['activation_point'],
            $json['protocol_version']
        );
    }
}
