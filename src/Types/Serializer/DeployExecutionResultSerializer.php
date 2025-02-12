<?php

namespace Casper\Types\Serializer;

use Casper\Types\DeployExecutionResult;

class DeployExecutionResultSerializer extends JsonSerializer
{
    /**
     * @param DeployExecutionResult $deployExecutionResult
     */
    public static function toJson($deployExecutionResult): array
    {
        return array(
            'block_hash' => $deployExecutionResult->getBlockHash(),
            'execution_result' => ExecutionResultV1Serializer::toJson($deployExecutionResult->getResult())
        );
    }

    public static function fromJson(array $json): DeployExecutionResult
    {
        return new DeployExecutionResult(
            $json['block_hash'],
            ExecutionResultV1Serializer::fromJson($json['result'])
        );
    }
}
