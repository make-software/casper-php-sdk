<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\Reward;

class RewardSerializer extends JsonSerializer
{
    /**
     * @param Reward $reward
     */
    public static function toJson($reward): array
    {
        return array(
            'amount' => (string) $reward->getAmount(),
            'validator' => $reward->getValidator()->toHex(),
        );
    }

    public static function fromJson(array $json)
    {
        return new Reward(
            gmp_init($json['amount']),
            CLPublicKey::fromHex($json['validator'])
        );
    }
}
