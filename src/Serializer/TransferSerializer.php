<?php

namespace Casper\Serializer;

use Casper\Entity\Transfer;

class TransferSerializer extends Serializer
{
    /**
     * @param Transfer $transfer
     * @return array
     */
    public static function toJson($transfer): array
    {
        // TODO: Implement toJson() method.
        return [];
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
