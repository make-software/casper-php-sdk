<?php

namespace Casper\Types\Serializer;

use Casper\Types\BlockHeaderV2;
use Casper\Types\CLValue\CLPublicKey;
use Casper\Util\DateTimeUtil;

class BlockHeaderV2Serializer extends JsonSerializer
{
    /**
     * @param BlockHeaderV2 $blockHeaderV2
     */
    public static function toJson($blockHeaderV2): array
    {
        return array(
            'parent_hash' => $blockHeaderV2->getParentHash(),
            'state_root_hash' => $blockHeaderV2->getStateRootHash(),
            'body_hash' => $blockHeaderV2->getBodyHash(),
            'random_bit' => $blockHeaderV2->isRandomBit(),
            'accumulated_seed' => $blockHeaderV2->getAccumulatedSeed(),
            'era_end' => $blockHeaderV2->getEraEnd() ? EraEndSerializer::toJson($blockHeaderV2->getEraEnd()) : null,
            'timestamp' => DateTimeUtil::getFormattedDateFromTimestampMs($blockHeaderV2->getTimestamp()),
            'era_id' => $blockHeaderV2->getEraId(),
            'height' => $blockHeaderV2->getHeight(),
            'protocol_version' => $blockHeaderV2->getProtocolVersion(),
            'current_gas_price' => (string) $blockHeaderV2->getCurrentGasPrice(),
            'proposer' => $blockHeaderV2->getProposer()->toHex(),
            'last_switch_block_hash' => $blockHeaderV2->getLastSwitchBlockHash(),
        );
    }

    public static function fromJson(array $json): BlockHeaderV2
    {
        return new BlockHeaderV2(
            $json['parent_hash'],
            $json['state_root_hash'],
            $json['body_hash'],
            $json['random_bit'],
            $json['accumulated_seed'],
            isset($json['era_end']) ? EraEndSerializer::fromJson($json['era_end']) : null,
            DateTimeUtil::getTimestampMsFromDateString($json['timestamp']),
            $json['era_id'],
            $json['height'],
            $json['protocol_version'],
            gmp_init($json['current_gas_price']),
            CLPublicKey::fromHex($json['proposer']),
            $json['last_switch_block_hash'],
        );
    }
}
