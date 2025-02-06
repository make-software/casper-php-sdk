<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\CLValue\CLURef;
use Casper\Types\Delegator;

class DelegatorSerializer extends JsonSerializer
{
    /**
     * @param Delegator $delegator
     */
    public static function toJson($delegator): array
    {
        return array(
            'public_key' => $delegator->getPublicKey()->toHex(),
            'staked_amount' => (string) $delegator->getStakedAmount(),
            'bonding_purse' => $delegator->getBondingPurse()->parsedValue(),
            'delegatee' => $delegator->getDelegatee()->toHex(),
        );
    }

    public static function fromJson(array $json): Delegator
    {
        return new Delegator(
            CLPublicKey::fromHex($json['public_key']),
            gmp_init($json['staked_amount']),
            CLURef::fromString($json['bonding_purse']),
            CLPublicKey::fromHex($json['delegatee'])
        );
    }
}
