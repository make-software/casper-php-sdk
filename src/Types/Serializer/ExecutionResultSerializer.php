<?php

namespace Casper\Types\Serializer;

use Casper\Types\ExecutionResult;

class ExecutionResultSerializer extends JsonSerializer
{
    /**
     * @param ExecutionResult $executionResult
     * @throws \Exception
     */
    public static function toJson($executionResult): array
    {
        if ($executionResult->getOriginExecutionResultV1()) {
            $json = ExecutionResultV1Serializer::toJson($executionResult->getOriginExecutionResultV1());
        }
        else if ($executionResult->getOriginExecutionResultV2()) {
            $json = ExecutionResultV2Serializer::toJson($executionResult->getOriginExecutionResultV2());
        }
        else {
            throw new \Exception('Invalid ExecutionResult');
        }

        return array(
            'Version' . ($executionResult->getOriginExecutionResultV1() ? '1' : '2') => $json,
        );
    }

    public static function fromJson(array $json): ExecutionResult
    {
        if (isset($json['Version2'])) {
            $executionResultV2 = ExecutionResultV2Serializer::fromJson($json['Version2']);
            return new ExecutionResult(
                $executionResultV2->getInitiatorAddr(),
                $executionResultV2->getErrorMessage(),
                $executionResultV2->getLimit(),
                $executionResultV2->getConsumed(),
                $executionResultV2->getCost(),
                $executionResultV2->getPayment(),
                $executionResultV2->getTransfers(),
                $executionResultV2->getSizeEstimate(),
                $executionResultV2->getEffects(),
                null,
                $executionResultV2
            );
        }
        else if (isset($json['Version1'])) {
            $executionResultV1 = ExecutionResultV1Serializer::fromJson($json['Version1']);

            // TODO: Implement from Version1
            if ($executionResultV1->getSuccess()) {
//                $transforms = [];
//                foreach ($executionResultV1->getSuccess()->getEffect()->getTransforms() as $transform) {
//                    $transforms[] = TransformSerializer::fromJson($transform);
//
//                    if ($transform->)
//                }
//
//                $consumed = $executionResultV1->getSuccess()->getCost();
//                return new ExecutionResult(
//                    null, null, 0, $consumed, 0, null, $transfers, null, $transforms, $executionResultV1, null
//                );
            }
            else if ($executionResultV1->getFailure()) {
                $transforms = [];
                foreach ($executionResultV1->getFailure()->getEffect()->getTransforms() as $transform) {
                    $transforms[] = TransformSerializer::fromJson($transform);
                }

                $errorMessage = $executionResultV1->getFailure()->getErrorMessage();
                $consumed = $executionResultV1->getFailure()->getCost();

                return new ExecutionResult(
                    null, $errorMessage, null, $consumed, null, null, null, null, $transforms, $executionResultV1, null
                );
            }
            else {
                throw new \Exception('Invalid ExecutionResultV1 structure');
            }
        }

        throw new \Exception('Incorrect RPC response structure');
    }
}
