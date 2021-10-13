<?php

namespace Casper\Serializer;

use Casper\Entity\BidInfo;

class BidInfoJsonSerializer extends JsonSerializer
{
    /**
     * @param BidInfo $bidInfo
     */
    public static function toJson($bidInfo): array
    {
        return array(
            'bonding_purse' => CLURefStringSerializer::toString($bidInfo->getBondingPurse()),
            'staked_amount' => (string) $bidInfo->getStakedAmount(),
            'delegation_rate' => $bidInfo->getDelegationRate(),
            'delegators' => DelegatorJsonSerializer::toJsonArray($bidInfo->getDelegators()),
            'inactive' => $bidInfo->isInactive(),
        );
    }

    public static function fromJson(array $json): BidInfo
    {
        return new BidInfo(
            CLURefStringSerializer::fromString($json['bonding_purse']),
            gmp_init($json['staked_amount']),
            $json['delegation_rate'],
            DelegatorJsonSerializer::fromJsonArray($json['delegators']),
            $json['inactive']
        );
    }
}
