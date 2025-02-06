<?php

namespace Casper\Types\Serializer;

use Casper\Types\TransactionV1Payload;
use Casper\Util\DateTimeUtil;

class TransactionV1PayloadSerializer extends JsonSerializer
{
    /**
     * @param TransactionV1Payload $transactionV1Payload
     * @throws \Exception
     */
    public static function toJson($transactionV1Payload): array
    {
        return array(
            'initiator_addr' => InitiatorAddrSerializer::toJson($transactionV1Payload->getInitiatorAddr()),
            'timestamp' => DateTimeUtil::getFormattedDateFromTimestampMs($transactionV1Payload->getTimestamp()),
            'ttl' => DateTimeUtil::ttlToString($transactionV1Payload->getTtl()),
            'pricing_mode' => PricingModeSerializer::toJson($transactionV1Payload->getPricingMode()),
            'china_name' => $transactionV1Payload->getChainName(),
            'fields' => PayloadFieldsSerializer::toJson($transactionV1Payload->getFields()),
        );
    }

    public static function fromJson(array $json): TransactionV1Payload
    {
        return new TransactionV1Payload(
            InitiatorAddrSerializer::fromJson($json['initiator_addr']),
            DateTimeUtil::getTimestampMsFromDateString($json['timestamp']),
            DateTimeUtil::ttlToInt($json['ttl']),
            PricingModeSerializer::fromJson($json['pricing_mode']),
            $json['chain_name'],
            PayloadFieldsSerializer::fromJson($json['fields'])
        );
    }
}
