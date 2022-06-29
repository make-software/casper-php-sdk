<?php

namespace Casper\Serializer;

use Casper\Entity\GlobalState;

class GlobalStateSerializer extends JsonSerializer
{
    /**
     * @param GlobalState $globalState
     */
    public static function toJson($globalState): array
    {
        return array(
            'block_header' => BlockHeaderSerializer::toJson($globalState->getBlockHeader()),
            'stored_value' => StoredValueSerializer::toJson($globalState->getStoredValue()),
        );
    }

    public static function fromJson(array $json): GlobalState
    {
        return new GlobalState(
            BlockHeaderSerializer::fromJson($json['block_header']),
            StoredValueSerializer::fromJson($json['stored_value'])
        );
    }
}
