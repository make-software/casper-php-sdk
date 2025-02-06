<?php

namespace Casper\Types\Serializer;

use Casper\Types\BidInfo;
use Casper\Types\CLValue\CLURef;

class BidInfoSerializer extends JsonSerializer
{
    /**
     * @param BidInfo $bidInfo
     */
    public static function toJson($bidInfo): array
    {
        return array(
            'bonding_purse' => $bidInfo->getBondingPurse()->parsedValue(),
            'staked_amount' => (string) $bidInfo->getStakedAmount(),
            'delegation_rate' => $bidInfo->getDelegationRate(),
            'delegators' => DelegatorSerializer::toJsonArray($bidInfo->getDelegators()),
            'inactive' => $bidInfo->isInactive(),
        );
    }

    public static function fromJson(array $json): BidInfo
    {
        return new BidInfo(
            CLURef::fromString($json['bonding_purse']),
            gmp_init($json['staked_amount']),
            $json['delegation_rate'],
            DelegatorSerializer::fromJsonArray($json['delegators']),
            $json['inactive']
        );
    }
}
