<?php

namespace Casper\Serializer;

use Casper\CLType\CLAccountHash;
use Casper\CLType\CLURef;
use Casper\Entity\Transfer;

class TransferJsonSerializer extends JsonSerializer
{
    /**
     * @param Transfer $transfer
     */
    public static function toJson($transfer): array
    {
        return array(
            'deploy_hash' => $transfer->getDeployHash(),
            'from' => CLAccountHashStringSerializer::toString($transfer->getFrom()),
            'to' => $transfer->getTo() ? CLAccountHashStringSerializer::toString($transfer->getTo()) : null,
            'source' => CLURefStringSerializer::toString($transfer->getSource()),
            'target' => CLURefStringSerializer::toString($transfer->getTarget()),
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
            CLAccountHashStringSerializer::fromString($json['from']),
            isset($json['to']) ? CLAccountHashStringSerializer::fromString($json['to']) : null,
            CLURefStringSerializer::fromString($json['source']),
            CLURefStringSerializer::fromString($json['target']),
            gmp_init($json['amount']),
            gmp_init($json['gas']),
            $json['id']
        );
    }
}
