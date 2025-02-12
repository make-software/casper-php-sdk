<?php

namespace Casper\Types\Serializer;

use Casper\Types\TransactionWrapper;

class TransactionWrapperSerializer extends JsonSerializer
{
    /**
     * @param TransactionWrapper $transactionWrapper
     * @throws \Exception
     */
    public static function toJson($transactionWrapper): array
    {
        if ($deploy = $transactionWrapper->getDeploy()) {
            return array(
                'Deploy' => DeploySerializer::toJson($deploy)
            );
        }
        else if ($transactionV1 = $transactionWrapper->getTransactionV1()) {
            return array(
                'Version1' => TransactionV1Serializer::toJson($transactionV1)
            );
        }

        throw new \Exception('TransactionWrapper deserialization error');
    }

    public static function fromJson(array $json): TransactionWrapper
    {
        return new TransactionWrapper(
            isset($json['Deploy']) ? DeploySerializer::fromJson($json['Deploy']) : null,
            isset($json['Version1']) ? TransactionV1Serializer::fromJson($json['Version1']) : null
        );
    }
}
