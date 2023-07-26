<?php

namespace Casper\Serializer;

use Casper\Entity\DeployExecutionResult;

class DeployExecutionResultSerializer extends JsonSerializer
{
    /**
     * @param DeployExecutionResult $deployExecutionResult
     */
    public static function toJson($deployExecutionResult): array
    {
        return array(
            'block_hash' => $deployExecutionResult->getBlockHash(),
            'execution_result' => DeployExecutionResultDataSerializer::toJson($deployExecutionResult->getData())
        );
    }

    public static function fromJson(array $json): DeployExecutionResult
    {
        return new DeployExecutionResult(
            $json['block_hash'],
            DeployExecutionResultDataSerializer::fromJson($json['execution_result'])
        );
    }
}
