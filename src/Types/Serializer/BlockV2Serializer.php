<?php

namespace Casper\Types\Serializer;

use Casper\Types\BlockV2;

class BlockV2Serializer extends JsonSerializer
{
    /**
     * @param BlockV2 $blockV2
     */
    public static function toJson($blockV2): array
    {
        return array(
            'hash' => $blockV2->getHash(),
            'header' => BlockHeaderV2Serializer::toJson($blockV2->getHeader()),
            'body' => BlockBodyV2Serializer::toJson($blockV2->getBody()),
        );
    }

    public static function fromJson(array $json): BlockV2
    {
        return new BlockV2(
            $json['hash'],
            BlockHeaderV2Serializer::fromJson($json['header']),
            BlockBodyV2Serializer::fromJson($json['body']),
        );
    }
}
