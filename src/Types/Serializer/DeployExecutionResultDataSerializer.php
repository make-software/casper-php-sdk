<?php

namespace Casper\Types\Serializer;

use Casper\Types\ExecutionResultStatusData;

class DeployExecutionResultDataSerializer extends JsonSerializer
{
    /**
     * @param ExecutionResultStatusData $deployExecutionResultData
     */
    public static function toJson($deployExecutionResultData): array
    {
        $result = array(
            $deployExecutionResultData->getStatus() => array(
                'effect' => EffectSerializer::toJson($deployExecutionResultData->getEffect()),
                'transfers' => $deployExecutionResultData->getTransfers(),
                'cost' => (string) $deployExecutionResultData->getCost(),
            )
        );

        if ($deployExecutionResultData->getErrorMessage() !== null) {
            $result[$deployExecutionResultData->getStatus()]['error_message'] =
                $deployExecutionResultData->getErrorMessage();
        }

        return $result;
    }

    public static function fromJson(array $json): ExecutionResultStatusData
    {
        $status = array_key_first($json);

        return new ExecutionResultStatusData(
            $status,
            EffectSerializer::fromJson($json[$status]['effect']),
            $json[$status]['transfers'],
            gmp_init($json[$status]['cost']),
            $json[$status]['error_message'] ?? null
        );
    }
}
