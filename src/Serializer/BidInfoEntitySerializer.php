<?php

namespace Casper\Serializer;

use Casper\Entity\BidInfo;

class BidInfoEntitySerializer extends EntitySerializer
{
    /**
     * @param BidInfo $bidInfo
     * @return array
     */
    public static function toJson($bidInfo): array
    {
        return array(
            'bonding_purse' => $bidInfo->getBondingPurse(),
            'staked_amount' => (string) $bidInfo->getStakedAmount(),
            'delegation_rate' => $bidInfo->getDelegationRate(),
            'delegators' => DelegatorEntitySerializer::toJsonArray($bidInfo->getDelegators()),
            'inactive' => $bidInfo->isInactive(),
        );
    }

    public static function fromJson(array $json): BidInfo
    {
        return new BidInfo(
            $json['bonding_purse'],
            gmp_init($json['staked_amount']),
            $json['delegation_rate'],
            DelegatorEntitySerializer::fromJsonArray($json['delegators']),
            $json['inactive']
        );
    }
}
