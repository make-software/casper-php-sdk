<?php

namespace Casper\Types\Serializer;

use Casper\Types\BlockWithSignatures;

class BlockWithSignaturesSerializer extends JsonSerializer
{
    /**
     * @param BlockWithSignatures $blockWithSignatures
     * @throws \Exception
     */
    public static function toJson($blockWithSignatures): array
    {
        return array(
            'block' => BlockWrapperSerializer::toJson($blockWithSignatures->getBlock()),
            'proofs' => BlockProofSerializer::toJsonArray($blockWithSignatures->getProofs()),
        );
    }

    public static function fromJson(array $json)
    {
        return new BlockWithSignatures(
            BlockWrapperSerializer::fromJson($json['block']),
            BlockProofSerializer::fromJsonArray($json['proofs']),
        );
    }
}
