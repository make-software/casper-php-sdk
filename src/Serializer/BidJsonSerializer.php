<?php

namespace Casper\Serializer;

use Casper\Entity\Bid;

class BidJsonSerializer extends JsonSerializer
{
    /**
     * @param Bid $bid
     */
    public static function toJson($bid): array
    {
        return array(
            'public_key' => CLPublicKeyStringSerializer::toString($bid->getPublicKey()),
            'bid' => BidInfoJsonSerializer::toJson($bid->getInfo()),
        );
    }

    public static function fromJson(array $json): Bid
    {
        return new Bid(
            CLPublicKeyStringSerializer::fromString($json['public_key']),
            BidInfoJsonSerializer::fromJson($json['bid'])
        );
    }
}
