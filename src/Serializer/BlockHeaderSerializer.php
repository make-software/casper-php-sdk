<?php

namespace Casper\Serializer;

use Casper\Entity\BlockHeader;

class BlockHeaderSerializer extends Serializer
{
    /**
     * @param BlockHeader $blockHeader
     * @return string[]
     */
    public static function toJson($blockHeader): array
    {
        return array(
            'parent_hash' => $blockHeader->getParentHash(),
            'state_root_hash' => $blockHeader->getStateRootHash(),
            'body_hash' => $blockHeader->getBodyHash(),
            'random_bit' => $blockHeader->isRandomBit(),
            'accumulated_seed' => $blockHeader->getAccumulatedSeed(),
            'era_end' => $blockHeader->getEraEnd(),
            'timestamp' => date('Y-m-d\TH:i:s.u\Z', $blockHeader->getTimestamp()),
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
            $json['era_end'],
            strtotime($json['timestamp']),
            $json['era_id'],
            $json['height'],
            $json['protocol_version'],
        );
    }
}
