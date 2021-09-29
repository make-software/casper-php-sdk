<?php

namespace Casper\Serializer;

use Casper\Entity\AuctionState;

class AuctionStateSerializer extends Serializer
{
    /**
     * @param AuctionState $actionState
     * @return array
     */
    public static function toJson($actionState): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): AuctionState
    {
        return new AuctionState(
            $json['state_root_hash'],
            $json['block_height'],
            EraValidatorSerializer::fromArray($json['era_validators']),
            BidSerializer::fromArray($json['bids'])
        );
    }
}
