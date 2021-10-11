<?php

namespace Casper\Serializer;

use Casper\Entity\Transfer;

class TransferEntitySerializer extends EntitySerializer
{
    /**
     * @param Transfer $transfer
     * @return array
     */
    public static function toJson($transfer): array
    {
        return array(
            'deploy_hash' => $transfer->getDeployHash(),
            'from' => $transfer->getFrom(),
            'to' => $transfer->getTo(),
            'source' => $transfer->getSource(),
            'target' => $transfer->getTarget(),
            'amount' => (string) $transfer->getAmount(),
            'gas' => (string) $transfer->getGas(),
            'id' => $transfer->getId(),
        );
    }

    public static function fromJson(array $json): Transfer
    {
        return new Transfer(
            $json['deploy_hash'],
            $json['from'],
            $json['to'],
            $json['source'],
            $json['target'],
            gmp_init($json['amount']),
            gmp_init($json['gas']),
            $json['id']
        );
    }
}
