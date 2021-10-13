<?php

namespace Casper\Serializer;

use Casper\Entity\EraSummary;

class EraSummaryJsonSerializer extends JsonSerializer
{
    /**
     * @param EraSummary $eraSummary
     * @return array
     */
    public static function toJson($eraSummary): array
    {
        return array(
            'block_hash' => $eraSummary->getBlockHash(),
            'era_id' => $eraSummary->getEraId(),
            'stored_value' => StoredValueJsonSerializer::toJson($eraSummary->getStoredValue()),
            'state_root_hash' => $eraSummary->getStateRootHash(),
        );
    }

    public static function fromJson(array $json): ?EraSummary
    {
        if (!$json) {
            return null;
        }

        return new EraSummary(
            $json['block_hash'],
            $json['era_id'],
            StoredValueJsonSerializer::fromJson($json['stored_value']),
            $json['state_root_hash']
        );
    }
}
