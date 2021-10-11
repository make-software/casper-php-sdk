<?php

namespace Casper\Serializer;

use Casper\Entity\Bid;

class BidEntitySerializer extends EntitySerializer
{
    /**
     * @param Bid $bid
     * @return array
     */
    public static function toJson($bid): array
    {
        return array(
            'public_key' => $bid->getPublicKey(),
            'bid' => BidInfoEntitySerializer::toJson($bid->getInfo()),
        );
    }

    public static function fromJson(array $json): Bid
    {
        return new Bid(
            $json['public_key'],
            BidInfoEntitySerializer::fromJson($json['bid'])
        );
    }
}
