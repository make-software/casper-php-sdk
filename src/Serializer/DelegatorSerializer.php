<?php

namespace Casper\Serializer;

use Casper\Entity\Delegator;

class DelegatorSerializer extends Serializer
{
    /**
     * @param Delegator $delegator
     * @return array
     */
    public static function toJson($delegator): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): Delegator
    {
        return new Delegator(
            $json['public_key'],
            gmp_init($json['staked_amount']),
            $json['bonding_purse'],
            $json['delegatee']
        );
    }
}
