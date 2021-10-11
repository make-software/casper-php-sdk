<?php

namespace Casper\Serializer;

use Casper\Entity\Block;
use Casper\Entity\BlockBody;
use Casper\Entity\BlockHeader;
use Casper\Entity\BlockProof;

class BlockEntitySerializer extends EntitySerializer
{
    /**
     * @param Block $block
     * @return array
     */
    public static function toJson($block): array
    {
        return array(
            'hash' => $block->getHash(),
            'header' => BlockHeaderEntitySerializer::toJson($block->getHeader()),
            'body' => BlockBodyEntitySerializer::toJson($block->getBody()),
            'proofs' => BlockProofEntitySerializer::toJsonArray($block->getProofs()),
        );
    }

    public static function fromJson(array $json): Block
    {
        return new Block(
            $json['hash'],
            BlockHeaderEntitySerializer::fromJson($json['header']),
            BlockBodyEntitySerializer::fromJson($json['body']),
            BlockProofEntitySerializer::fromJsonArray($json['proofs'])
        );
    }
}
