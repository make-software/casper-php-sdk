<?php

namespace Casper\Types\Serializer;

use Casper\Types\PayloadFields;

class PayloadFieldsSerializer extends JsonSerializer
{
    /**
     * @param PayloadFields $payloadFields
     * @throws \Exception
     */
    public static function toJson($payloadFields): array
    {
        return array(
            'args' => array(
                'Named' => NamedArgSerializer::toJsonArray($payloadFields->getArgs())
            ),
            'entry_point' => $payloadFields->getEntryPoint(),
            'scheduling' => $payloadFields->getScheduling(),
            'target' => TransactionTargetSerializer::toJson($payloadFields->getTarget()),
        );
    }

    public static function fromJson(array $json): PayloadFields
    {
        return new PayloadFields(
            NamedArgSerializer::fromJsonArray($json['args']['Named']),
            $json['entry_point'],
            $json['scheduling'],
            TransactionTargetSerializer::fromJson($json['target'])
        );
    }
}
