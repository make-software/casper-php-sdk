<?php

namespace Casper\Types\Serializer;

use Casper\Types\ExecutionResultStatusData;

class ExecutionResultStatusDataSerializer extends JsonSerializer
{
    /**
     * @param ExecutionResultStatusData $executionResultStatusData
     */
    public static function toJson($executionResultStatusData): array
    {
        return array(
            'status' => $executionResultStatusData->getStatus(),
            'effect' => EffectSerializer::toJson($executionResultStatusData->getEffect()),
            'transfers' => TransferSerializer::toJsonArray($executionResultStatusData->getTransfers()),
            'cost' => (string) $executionResultStatusData->getCost(),
            'error_message' => $executionResultStatusData->getErrorMessage(),
        );
    }

    public static function fromJson(array $json): ExecutionResultStatusData
    {
        return new ExecutionResultStatusData(
            $json['status'],
            EffectSerializer::fromJson($json['effect']),
            TransferSerializer::fromJsonArray($json['transfers']),
            gmp_init($json['cost']),
            $json['error_message']
        );
    }
}
