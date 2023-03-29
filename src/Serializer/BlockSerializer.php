<?php

namespace Casper\Serializer;

use Casper\Entity\Block;

class BlockSerializer extends JsonSerializer
{
    /**
     * @param Block $block
     */
    public static function toJson($block): array
    {
        return array(
            'hash' => $block->getHash(),
            'header' => BlockHeaderSerializer::toJson($block->getHeader()),
            'body' => BlockBodySerializer::toJson($block->getBody()),
            'proofs' => BlockProofSerializer::toJsonArray($block->getProofs()),
        );
    }

    public static function fromJson(array $json): Block
    {
        return new Block(
            $json['hash'],
            BlockHeaderSerializer::fromJson($json['header']),
            BlockBodySerializer::fromJson($json['body']),
            BlockProofSerializer::fromJsonArray($json['proofs'])
        );
    }
}
