<?php

namespace Casper\Types\Serializer;

use Casper\Types\NextUpgrade;

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
