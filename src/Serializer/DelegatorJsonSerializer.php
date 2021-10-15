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
            'public_key' => CLPublicKeyStringSerializer::toHex($delegator->getPublicKey()),
            'staked_amount' => (string) $delegator->getStakedAmount(),
            'bonding_purse' => CLURefStringSerializer::toString($delegator->getBondingPurse()),
            'delegatee' => CLPublicKeyStringSerializer::toHex($delegator->getDelegatee()),
        );
    }

    public static function fromJson(array $json): Delegator
    {
        return new Delegator(
            CLPublicKeyStringSerializer::fromHex($json['public_key']),
            gmp_init($json['staked_amount']),
            CLURefStringSerializer::fromString($json['bonding_purse']),
            CLPublicKeyStringSerializer::fromHex($json['delegatee'])
        );
    }
}
