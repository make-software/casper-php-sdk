<?php

namespace Casper\Types\Serializer;

use Casper\Types\TransactionWrapper;

class TransactionWrapperSerializer extends JsonSerializer
{
    /**
     * @param TransactionWrapper $transactionWrapper
     */
    public static function toJson($transactionWrapper): array
    {
        return array();
    }

    public static function fromJson(array $json): TransactionWrapper
    {
        return new TransactionWrapper(
            isset($json['Deploy']) ? DeploySerializer::fromJson($json['Deploy']) : null,
            isset($json['Version1']) ? TransactionV1Serializer::fromJson($json['Version1']) : null
        );
    }
}
