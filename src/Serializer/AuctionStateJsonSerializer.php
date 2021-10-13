<?php

namespace Casper\Serializer;

use Casper\Entity\AuctionState;

class AuctionStateJsonSerializer extends JsonSerializer
{
    /**
     * @param AuctionState $actionState
     */
    public static function toJson($actionState): array
    {
        return array(
            'state_root_hash' => $actionState->getStateRootHash(),
            'block_height' => $actionState->getBlockHeight(),
            'era_validators' => EraValidatorJsonSerializer::toJsonArray($actionState->getEraValidators()),
            'bids' => BidJsonSerializer::toJsonArray($actionState->getBids()),
        );
    }

    public static function fromJson(array $json): AuctionState
    {
        return new AuctionState(
            $json['state_root_hash'],
            $json['block_height'],
            EraValidatorJsonSerializer::fromJsonArray($json['era_validators']),
            BidJsonSerializer::fromJsonArray($json['bids'])
        );
    }
}
