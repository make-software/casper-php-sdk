<?php

namespace Casper\Serializer;

use Casper\Entity\AuctionState;

class AuctionStateEntitySerializer extends EntitySerializer
{
    /**
     * @param AuctionState $actionState
     * @return array
     */
    public static function toJson($actionState): array
    {
        return array(
            'state_root_hash' => $actionState->getStateRootHash(),
            'block_height' => $actionState->getBlockHeight(),
            'era_validators' => EraValidatorEntitySerializer::toJsonArray($actionState->getEraValidators()),
            'bids' => BidEntitySerializer::toJsonArray($actionState->getBids()),
        );
    }

    public static function fromJson(array $json): AuctionState
    {
        return new AuctionState(
            $json['state_root_hash'],
            $json['block_height'],
            EraValidatorEntitySerializer::fromJsonArray($json['era_validators']),
            BidEntitySerializer::fromJsonArray($json['bids'])
        );
    }
}
