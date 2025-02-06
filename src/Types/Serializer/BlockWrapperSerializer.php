<?php

namespace Casper\Types\Serializer;

use Casper\Types\BlockWrapper;

class BlockWrapperSerializer extends JsonSerializer
{
    /**
     * @param BlockWrapper $blockWrapper
     * @throws \Exception
     */
    public static function toJson($blockWrapper): array
    {
        if ($blockWrapper->getBlockV1() !== null) {
            $json = BlockV1Serializer::toJson($blockWrapper->getBlockV1());
        }
        else if ($blockWrapper->getBlockV2() !== null) {
            $json = BlockV2Serializer::toJson($blockWrapper->getBlockV2());
        }
        else {
            throw new \Exception('BlockWrapper does not contain any block');
        }

        return array(
            'Version' . ($blockWrapper->getBlockV1() !== null ? '1' : '2') => $json,
        );
    }

    public static function fromJson(array $json): BlockWrapper
    {
        return new BlockWrapper(
            isset($json['Version1']) ? BlockV1Serializer::fromJson($json['Version1']) : null,
            isset($json['Version2']) ? BlockV2Serializer::fromJson($json['Version2']) : null
        );
    }
}
