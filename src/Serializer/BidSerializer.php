<?php

namespace Casper\Serializer;

use Casper\Entity\Bid;

class BidSerializer extends Serializer
{
    /**
     * @param Bid $bid
     * @return array
     */
    public static function toJson($bid): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): Bid
    {
        return new Bid(
            $json['public_key'],
            BidInfoSerializer::fromJson($json['bid'])
        );
    }
}
