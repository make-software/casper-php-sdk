<?php

namespace Casper\Serializer;

use Casper\Entity\Reward;

class RewardSerializer extends JsonSerializer
{
    /**
     * @param Reward $reward
     */
    public static function toJson($reward): array
    {
        return array(
            'amount' => (string) $reward->getAmount(),
            'validator' => CLPublicKeySerializer::toHex($reward->getValidator()),
        );
    }

    public static function fromJson(array $json)
    {
        return new Reward(
            gmp_init($json['amount']),
            CLPublicKeySerializer::fromHex($json['validator'])
        );
    }
}
