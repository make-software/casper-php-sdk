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
        if ($executionResultV1->getSuccess()) {
            return array(
                'Success' => ExecutionResultStatusDataSerializer::toJson($executionResultV1->getSuccess())
            );
        }
        else if ($executionResultV1->getFailure()) {
            return array(
                'Failure' => ExecutionResultStatusDataSerializer::toJson($executionResultV1->getFailure())
            );
        }

        throw new \Exception('Unable deserialize ExecutionResultV1');
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
