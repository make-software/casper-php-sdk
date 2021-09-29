<?php

namespace Casper\Serializer;

use Casper\Entity\BidInfo;

class BidInfoSerializer extends Serializer
{
    /**
     * @param BidInfo $bidInfo
     * @return array
     */
    public static function toJson($bidInfo): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): BidInfo
    {
        return new BidInfo(
            $json['bonding_purse'],
            gmp_init($json['staked_amount']),
            $json['delegation_rate'],
            DelegatorSerializer::fromArray($json['delegators']),
            $json['inactive']
        );
    }
}
