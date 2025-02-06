<?php

namespace Casper\Types\Serializer;

use Casper\Types\TransactionHash;

class TransactionHashSerializer extends JsonSerializer
{
    /**
     * @param TransactionHash $transactionHash
     * @throws \Exception
     */
    public static function toJson($transactionHash): array
    {
        if ($transactionHash->getDeploy()) {
            return array(
                'Deploy' => $transactionHash->getDeploy()
            );
        }
        else if ($transactionHash->getTransactionV1()) {
            return array(
                'Version1' => $transactionHash->getTransactionV1()
            );
        }

        throw new \Exception('Invalid TransactionHash');
    }

    public static function fromJson(array $json): TransactionHash
    {
        return new TransactionHash(
            $json['Deploy'] ?? null,
            $json['Version1'] ?? null
        );
    }
}
