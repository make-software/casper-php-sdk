<?php

namespace Casper\Types\Serializer;

use Casper\Types\BlockWithSignatures;

class BlockWithSignaturesSerializer extends JsonSerializer
{
    /**
     * @param BlockWithSignatures $blockWithSignatures
     */
    public static function toJson($blockWithSignatures): array
    {
        return array();
    }

    public static function fromJson(array $json)
    {
        return new BlockWithSignatures(
            BlockWrapperSerializer::fromJson($json['block']),
            BlockProofSerializer::fromJsonArray($json['proofs']),
        );
    }
}
