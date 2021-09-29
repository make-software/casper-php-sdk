<?php

namespace Casper\Serializer;

use Casper\Entity\EraSummary;

class EraSummarySerializer extends Serializer
{
    /**
     * @param EraSummary $eraSummary
     * @return array
     */
    public static function toJson($eraSummary): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): ?EraSummary
    {
        if (!$json) {
            return null;
        }

        return new EraSummary(
            $json['block_hash'],
            $json['era_id'],
            StoredValueSerializer::fromJson($json['stored_value']),
            $json['state_root_hash']
        );
    }
}
