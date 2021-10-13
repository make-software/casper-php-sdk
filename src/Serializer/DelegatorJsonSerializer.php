<?php

namespace Casper\Serializer;

use Casper\Entity\Delegator;

class DelegatorJsonSerializer extends JsonSerializer
{
    /**
     * @param Delegator $delegator
     */
    public static function toJson($delegator): array
    {
        return array(
            'public_key' => CLPublicKeyStringSerializer::toString($delegator->getPublicKey()),
            'staked_amount' => (string) $delegator->getStakedAmount(),
            'bonding_purse' => CLURefStringSerializer::toString($delegator->getBondingPurse()),
            'delegatee' => CLPublicKeyStringSerializer::toString($delegator->getDelegatee()),
        );
    }

    public static function fromJson(array $json): Delegator
    {
        return new Delegator(
            CLPublicKeyStringSerializer::fromString($json['public_key']),
            gmp_init($json['staked_amount']),
            CLURefStringSerializer::fromString($json['bonding_purse']),
            CLPublicKeyStringSerializer::fromString($json['delegatee'])
        );
    }
}
