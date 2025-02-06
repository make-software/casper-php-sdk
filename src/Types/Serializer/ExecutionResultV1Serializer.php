<?php

namespace Casper\Types\Serializer;

use Casper\Types\ExecutionResultV1;

class ExecutionResultV1Serializer extends JsonSerializer
{
    /**
     * @param ExecutionResultV1 $executionResultV1
     */
    public static function toJson($executionResultV1): array
    {
        return array();
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): ExecutionResultV1
    {
        return new ExecutionResultV1(
            isset($json['Success']) ? ExecutionResultStatusDataSerializer::fromJson($json['Success']) : null,
            isset($json['Failure']) ? ExecutionResultStatusDataSerializer::fromJson($json['Failure']) : null
        );
    }
}
