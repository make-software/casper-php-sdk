<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLAccountHash;
use Casper\Types\CLValue\CLURef;
use Casper\Types\TransferV2;

class TransferV2Serializer extends JsonSerializer
{
    /**
     * @param TransferV2 $transferV2
     */
    public static function toJson($transferV2): array
    {
        return array(
            'transaction_hash' => TransactionHashSerializer::toJson($transferV2->getTransactionHash()),
            'from' => InitiatorAddrSerializer::toJson($transferV2->getFrom()),
            'to' => $transferV2->getTo() ? $transferV2->getTo()->parsedValue() : null,
            'source' => $transferV2->getSource()->parsedValue(),
            'target' => $transferV2->getTarget()->parsedValue(),
            'amount' => gmp_strval($transferV2->getAmount()),
            'gas' => gmp_strval($transferV2->getGas()),
            'id' => $transferV2->getId()
        );
    }

    public static function fromJson(array $json): TransferV2
    {
        return new TransferV2(
            TransactionHashSerializer::fromJson($json['transaction_hash']),
            InitiatorAddrSerializer::fromJson($json['from']),
            isset($json['to']) ? CLAccountHash::fromString($json['to']) : null,
            CLURef::fromString($json['source']),
            CLURef::fromString($json['target']),
            gmp_init($json['amount']),
            gmp_init($json['gas']),
            $json['id']
        );
    }
}
