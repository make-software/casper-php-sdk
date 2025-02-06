<?php

namespace Casper\Types\Serializer;

use Casper\Types\Serializer\JsonSerializer;
use Casper\Types\BlockRange;

class BlockRangeSerializer extends JsonSerializer
{
    /**
     * @param BlockRange $blockRange
     */
    public static function toJson($blockRange): array
    {
        return array(
            'low' => $blockRange->getLow(),
            'high' => $blockRange->getHigh(),
        );
    }

    public static function fromJson(array $json): BlockRange
    {
        return new BlockRange($json['low'], $json['high']);
    }
}
