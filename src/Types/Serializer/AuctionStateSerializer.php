<?php

namespace Casper\Types\Serializer;

use Casper\Types\AuctionState;

class AuctionStateSerializer extends JsonSerializer
{
    /**
     * @param AuctionState $actionState
     */
    public static function toJson($actionState): array
    {
        return array(
            'state_root_hash' => $actionState->getStateRootHash(),
            'block_height' => $actionState->getBlockHeight(),
            'era_validators' => EraValidatorSerializer::toJsonArray($actionState->getEraValidators()),
            'bids' => BidSerializer::toJsonArray($actionState->getBids()),
        );
    }

    public static function fromJson(array $json): AuctionState
    {
        return new AuctionState(
            $json['state_root_hash'],
            $json['block_height'],
            EraValidatorSerializer::fromJsonArray($json['era_validators']),
            BidSerializer::fromJsonArray($json['bids'])
        );
    }
}
