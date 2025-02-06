<?php

namespace Casper\Types\Serializer;

use Casper\Types\TransactionV1;

class TransactionV1Serializer extends JsonSerializer
{
    /**
     * @param TransactionV1 $transactionV1
     * @throws \Exception
     */
    public static function toJson($transactionV1): array
    {
        return array(
            'hash' => $transactionV1->getHash(),
            'payload' => TransactionV1PayloadSerializer::toJson($transactionV1->getPayload()),
            'approvals' => ApprovalSerializer::toJsonArray($transactionV1->getApprovals()),
        );
    }

    public static function fromJson(array $json): TransactionV1
    {
        return new TransactionV1(
            $json['hash'],
            TransactionV1PayloadSerializer::fromJson($json['payload']),
            ApprovalSerializer::fromJsonArray($json['approvals'])
        );
    }
}
