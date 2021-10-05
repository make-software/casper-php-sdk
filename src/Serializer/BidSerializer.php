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
        return array(
            'public_key' => $bid->getPublicKey(),
            'bid' => BidInfoSerializer::toJson($bid->getInfo()),
        );
    }

    public static function fromJson(array $json): Bid
    {
        return new Bid(
            $json['public_key'],
            BidInfoSerializer::fromJson($json['bid'])
        );
    }
}
