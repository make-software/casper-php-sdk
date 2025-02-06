<?php

namespace Casper\Types\Serializer;

use Casper\Types\BlockV1;

class BlockV1Serializer extends JsonSerializer
{
    /**
     * @param BlockV1 $blockV1
     */
    public static function toJson($blockV1): array
    {
        return array(
            'hash' => $blockV1->getHash(),
            'header' => BlockHeaderV1Serializer::toJson($blockV1->getHeader()),
            'body' => BlockBodyV1Serializer::toJson($blockV1->getBody()),
            'proofs' => BlockProofSerializer::toJsonArray($blockV1->getProofs()),
        );
    }

    public static function fromJson(array $json): BlockV1
    {
        return new BlockV1(
            $json['hash'],
            BlockHeaderV1Serializer::fromJson($json['header']),
            BlockBodyV1Serializer::fromJson($json['body']),
            BlockProofSerializer::fromJsonArray($json['proofs'])
        );
    }
}
