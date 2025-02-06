<?php

namespace Casper\Types\Serializer;

use Casper\Types\BlockHeaderV1;
use Casper\Util\DateTimeUtil;

class BlockHeaderV1Serializer extends JsonSerializer
{
    /**
     * @param BlockHeaderV1 $blockHeaderV1
     */
    public static function toJson($blockHeaderV1): array
    {
        return array(
            'parent_hash' => $blockHeaderV1->getParentHash(),
            'state_root_hash' => $blockHeaderV1->getStateRootHash(),
            'body_hash' => $blockHeaderV1->getBodyHash(),
            'random_bit' => $blockHeaderV1->isRandomBit(),
            'accumulated_seed' => $blockHeaderV1->getAccumulatedSeed(),
            'era_end' => $blockHeaderV1->getEraEnd() ? EraEndSerializer::toJson($blockHeaderV1->getEraEnd()) : null,
            'timestamp' => DateTimeUtil::getFormattedDateFromTimestampMs($blockHeaderV1->getTimestamp()),
            'era_id' => $blockHeaderV1->getEraId(),
            'height' => $blockHeaderV1->getHeight(),
            'protocol_version' => $blockHeaderV1->getProtocolVersion(),
        );
    }

    public static function fromJson(array $json): BlockHeaderV1
    {
        return new BlockHeaderV1(
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
        );
    }
}
