<?php

namespace Casper\Serializer;

use Casper\Entity\Block;
use Casper\Entity\BlockBody;
use Casper\Entity\BlockHeader;
use Casper\Entity\BlockProof;

class BlockJsonSerializer extends JsonSerializer
{
    /**
     * @param Block $block
     */
    public static function toJson($block): array
    {
        return array(
            'hash' => $block->getHash(),
            'header' => BlockHeaderJsonSerializer::toJson($block->getHeader()),
            'body' => BlockBodyJsonSerializer::toJson($block->getBody()),
            'proofs' => BlockProofJsonSerializer::toJsonArray($block->getProofs()),
        );
    }

    public static function fromJson(array $json): Block
    {
        return new Block(
            $json['hash'],
            BlockHeaderJsonSerializer::fromJson($json['header']),
            BlockBodyJsonSerializer::fromJson($json['body']),
            BlockProofJsonSerializer::fromJsonArray($json['proofs'])
        );
    }
}
