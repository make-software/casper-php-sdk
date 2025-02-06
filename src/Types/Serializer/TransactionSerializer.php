<?php

namespace Casper\Types\Serializer;

use Casper\Types\Transaction;
use Casper\Util\DateTimeUtil;

class TransactionSerializer extends JsonSerializer
{
    /**
     * @param Transaction $transaction
     */
    public static function toJson($transaction): array
    {
        return array();
    }

    public static function fromJson(array $json): Transaction
    {
        return new Transaction(
            $json['hash'],
            $json['chain_name'],
            DateTimeUtil::getTimestampMsFromDateString($json['timestamp']),
            DateTimeUtil::ttlToInt($json['ttl']),
            InitiatorAddrSerializer::fromJson($json['initiator_addr']),
            PricingModeSerializer::fromJson($json['pricing_mode']),
            $json['args'],
            $json['target'],
            $json['entry_point'],
            $json['scheduling'],
            ApprovalSerializer::fromJsonArray($json['approvals']),
            null,
            null
        );
    }
}
