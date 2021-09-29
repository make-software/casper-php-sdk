<?php

namespace Casper\Serializer;

use Casper\Entity\BlockInfo;

class BlockInfoSerializer extends Serializer
{
    /**
     * @param BlockInfo $blockInfo
     * @return array
     */
    public static function toJson($blockInfo): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): BlockInfo
    {
        return new BlockInfo(
            $json['hash'],
            strtotime($json['timestamp']),
            $json['era_id'],
            $json['height'],
            $json['state_root_hash'],
            $json['creator']
        );
    }
}
