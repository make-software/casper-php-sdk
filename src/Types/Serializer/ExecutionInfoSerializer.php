<?php

namespace Casper\Types\Serializer;

use Casper\Types\ExecutionInfo;

class ExecutionInfoSerializer extends JsonSerializer
{
    /**
     * @param ExecutionInfo $executionInfo
     */
    public static function toJson($executionInfo): array
    {
        return array(
            'block_hash' => $executionInfo->getBlockHash(),
            'block_height' => $executionInfo->getBlockHeight(),
            'execution_result' => ExecutionResultSerializer::toJson($executionInfo->getExecutionResult()),
        );
    }

    public static function fromJson(array $json): ExecutionInfo
    {
        return new ExecutionInfo(
            $json['block_hash'],
            $json['block_height'],
            ExecutionResultSerializer::fromJson($json['execution_result'])
        );
    }
}
