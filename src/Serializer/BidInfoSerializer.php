<?php

namespace Casper\Serializer;

use Casper\Entity\BidInfo;

class BidInfoSerializer extends JsonSerializer
{
    /**
     * @param BidInfo $bidInfo
     */
    public static function toJson($bidInfo): array
    {
        return array(
            'bonding_purse' => CLURefSerializer::toString($bidInfo->getBondingPurse()),
            'staked_amount' => (string) $bidInfo->getStakedAmount(),
            'delegation_rate' => $bidInfo->getDelegationRate(),
            'delegators' => DelegatorSerializer::toJsonArray($bidInfo->getDelegators()),
            'inactive' => $bidInfo->isInactive(),
        );
    }

    public static function fromJson(array $json): BidInfo
    {
        return new BidInfo(
            CLURefSerializer::fromString($json['bonding_purse']),
            gmp_init($json['staked_amount']),
            $json['delegation_rate'],
            DelegatorSerializer::fromJsonArray($json['delegators']),
            $json['inactive']
        );
    }
}
