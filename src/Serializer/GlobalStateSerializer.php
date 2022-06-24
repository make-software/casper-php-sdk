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
            'node_id' => BlockHeaderSerializer::toJson($globalState->getBlockHeader()),
            'address' => StoredValueSerializer::toJson($globalState->getStoredValue()),
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
