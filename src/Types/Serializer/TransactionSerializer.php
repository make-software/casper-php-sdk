<?php

namespace Casper\Types\Serializer;

use Casper\Types\Transaction;
use Casper\Util\DateTimeUtil;

class TransactionSerializer extends JsonSerializer
{
    /**
     * @param Transaction $transaction
     * @throws \Exception
     */
    public static function toJson($transaction): array
    {
        return array(
            'hash' => $transaction->getHash(),
            'chain_name' => $transaction->getChainName(),
            'timestamp' => DateTimeUtil::getFormattedDateFromTimestampMs($transaction->getTimestamp()),
            'ttl' => DateTimeUtil::ttlToString($transaction->getTtl()),
            'initiator_addr' => InitiatorAddrSerializer::toJson($transaction->getInitiatorAddr()),
            'pricing_mode' => PricingModeSerializer::toJson($transaction->getPricingMode()),
            'args' => $transaction->getArgs(),
            'target' => $transaction->getTarget(),
            'entry_point' => $transaction->getEntryPoint(),
            'scheduling' => $transaction->getScheduling(),
            'approvals' => ApprovalSerializer::toJsonArray($transaction->getApprovals()),
        );
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
