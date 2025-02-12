<?php

namespace Casper\Types\Serializer;

use Casper\Types\ExecutionResultStatusData;

class ExecutionResultStatusDataSerializer extends JsonSerializer
{
    /**
     * @param ExecutionResultStatusData $executionResultStatusData
     * @throws \Exception
     */
    public static function toJson($executionResultStatusData): array
    {
        $json = array(
            'effect' => EffectSerializer::toJson($executionResultStatusData->getEffect()),
            'transfers' => TransferSerializer::toJsonArray($executionResultStatusData->getTransfers()),
            'cost' => (string) $executionResultStatusData->getCost(),
        );

        if ($executionResultStatusData->getErrorMessage()) {
            $json['error_message'] = $executionResultStatusData->getErrorMessage();
        }

        return $json;
    }

    public static function fromJson(array $json): ExecutionResultStatusData
    {
        return new ExecutionResultStatusData(
            EffectSerializer::fromJson($json['effect']),
            TransferSerializer::fromJsonArray($json['transfers']),
            gmp_init($json['cost']),
            $json['error_message'] ?? null
        );
    }
}
