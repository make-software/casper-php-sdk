<?php

namespace Casper\Types\Serializer;

use Casper\Types\Bid;
use Casper\Types\CLValue\CLPublicKey;

class BidSerializer extends JsonSerializer
{
    /**
     * @param Bid $bid
     */
    public static function toJson($bid): array
    {
        return array(
            'public_key' => $bid->getPublicKey()->toHex(),
            'bid' => BidInfoSerializer::toJson($bid->getInfo()),
        );
    }

    public static function fromJson(array $json): Bid
    {
        return new Bid(
            CLPublicKey::fromHex($json['public_key']),
            BidInfoSerializer::fromJson($json['bid'])
        );
    }
}
