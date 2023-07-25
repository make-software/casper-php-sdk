<?php

namespace Casper\Serializer;

use Casper\Util\DateUtil;

use Casper\Entity\BlockHeader;

class BlockHeaderSerializer extends JsonSerializer
{
    /**
     * @param BlockHeader $blockHeader
     */
    public static function toJson($blockHeader): array
    {
        return array(
            'parent_hash' => $blockHeader->getParentHash(),
            'state_root_hash' => $blockHeader->getStateRootHash(),
            'body_hash' => $blockHeader->getBodyHash(),
            'random_bit' => $blockHeader->isRandomBit(),
            'accumulated_seed' => $blockHeader->getAccumulatedSeed(),
            'era_end' => $blockHeader->getEraEnd() ? EraEndSerializer::toJson($blockHeader->getEraEnd()) : null,
            'timestamp' => DateUtil::getFormattedDateFromTimestampMs($blockHeader->getTimestamp()),
            'era_id' => $blockHeader->getEraId(),
            'height' => $blockHeader->getHeight(),
            'protocol_version' => $blockHeader->getProtocolVersion(),
        );
    }

    public static function fromJson(array $json): BlockHeader
    {
        return new BlockHeader(
            $json['parent_hash'],
            $json['state_root_hash'],
            $json['body_hash'],
            $json['random_bit'],
            $json['accumulated_seed'],
            isset($json['era_end']) ? EraEndSerializer::fromJson($json['era_end']) : null,
            DateUtil::getTimestampMsFromDateString($json['timestamp']),
            $json['era_id'],
            $json['height'],
            $json['protocol_version'],
        );
    }
}
