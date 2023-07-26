<?php

namespace Casper\Serializer;

use Casper\Entity\DeployExecutionResultData;

class DeployExecutionResultDataSerializer extends JsonSerializer
{
    /**
     * @param DeployExecutionResultData $deployExecutionResultData
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

    public static function fromJson(array $json): DeployExecutionResultData
    {
        $status = array_key_first($json);

        return new DeployExecutionResultData(
            $status,
            EffectSerializer::fromJson($json[$status]['effect']),
            $json[$status]['transfers'],
            gmp_init($json[$status]['cost']),
            $json[$status]['error_message'] ?? null
        );
    }
}
