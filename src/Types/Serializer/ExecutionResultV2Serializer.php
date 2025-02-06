<?php

namespace Casper\Types\Serializer;

use Casper\Types\ExecutionResultV2;

class ExecutionResultV2Serializer extends JsonSerializer
{
    /**
     * @param ExecutionResultV2 $executionResultV2
     * @throws \Exception
     */
    public static function toJson($executionResultV2): array
    {
        $json = array(
            'initiator' => InitiatorAddrSerializer::toJson($executionResultV2->getInitiatorAddr()),
            'error_message' => $executionResultV2->getErrorMessage(),
            'limit' => gmp_strval($executionResultV2->getLimit()),
            'consumed' => gmp_strval($executionResultV2->getConsumed()),
            'cost' => gmp_strval($executionResultV2->getCost()),
            'transfers' => TransferSerializer::toJsonArray($executionResultV2->getTransfers()),
            'size_estimate' => $executionResultV2->getSizeEstimate(),
            'effects' => TransformSerializer::toJsonArray($executionResultV2->getEffects()),
        );

        if ($executionResultV2->getPayment() !== null) {
            $json['payment'] = $executionResultV2->getPayment();
        }

        return $json;
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): ExecutionResultV2
    {
        return new ExecutionResultV2(
            InitiatorAddrSerializer::fromJson($json['initiator']),
            $json['error_message'],
            gmp_init($json['limit']),
            gmp_init($json['consumed']),
            gmp_init($json['cost']),
            $json['payment'] ?? null,
            TransferSerializer::fromJsonArray($json['transfers']),
            $json['size_estimate'],
            TransformSerializer::fromJsonArray($json['effects']),
        );
    }
}
