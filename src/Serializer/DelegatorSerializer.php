<?php

namespace Casper\Serializer;

use Casper\Entity\Delegator;

class DelegatorSerializer extends JsonSerializer
{
    /**
     * @param Delegator $delegator
     */
    public static function toJson($delegator): array
    {
        return array(
            'public_key' => CLPublicKeySerializer::toHex($delegator->getPublicKey()),
            'staked_amount' => (string) $delegator->getStakedAmount(),
            'bonding_purse' => CLURefSerializer::toString($delegator->getBondingPurse()),
            'delegatee' => CLPublicKeySerializer::toHex($delegator->getDelegatee()),
        );
    }

    public static function fromJson(array $json): Delegator
    {
        return new Delegator(
            CLPublicKeySerializer::fromHex($json['public_key']),
            gmp_init($json['staked_amount']),
            CLURefSerializer::fromString($json['bonding_purse']),
            CLPublicKeySerializer::fromHex($json['delegatee'])
        );
    }
}
