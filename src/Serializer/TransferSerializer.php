<?php

namespace Casper\Serializer;

use Casper\CLType\CLAccountHash;
use Casper\CLType\CLURef;
use Casper\Entity\Transfer;

class TransferSerializer extends JsonSerializer
{
    /**
     * @param Transfer $transfer
     */
    public static function toJson($transfer): array
    {
        return array(
            'deploy_hash' => $transfer->getDeployHash(),
            'from' => CLAccountHashSerializer::toString($transfer->getFrom()),
            'to' => $transfer->getTo() ? CLAccountHashSerializer::toString($transfer->getTo()) : null,
            'source' => CLURefSerializer::toString($transfer->getSource()),
            'target' => CLURefSerializer::toString($transfer->getTarget()),
            'amount' => (string) $transfer->getAmount(),
            'gas' => (string) $transfer->getGas(),
            'id' => $transfer->getId(),
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): Transfer
    {
        return new Transfer(
            $json['deploy_hash'],
            CLAccountHashSerializer::fromString($json['from']),
            isset($json['to']) ? CLAccountHashSerializer::fromString($json['to']) : null,
            CLURefSerializer::fromString($json['source']),
            CLURefSerializer::fromString($json['target']),
            gmp_init($json['amount']),
            gmp_init($json['gas']),
            $json['id']
        );
    }
}
