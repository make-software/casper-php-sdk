<?php

namespace Casper\Serializer;

use Casper\Entity\Bid;

class BidSerializer extends JsonSerializer
{
    /**
     * @param Bid $bid
     */
    public static function toJson($bid): array
    {
        return array(
            'public_key' => CLPublicKeySerializer::toHex($bid->getPublicKey()),
            'bid' => BidInfoSerializer::toJson($bid->getInfo()),
        );
    }

    public static function fromJson(array $json): Bid
    {
        return new Bid(
            CLPublicKeySerializer::fromHex($json['public_key']),
            BidInfoSerializer::fromJson($json['bid'])
        );
    }
}
