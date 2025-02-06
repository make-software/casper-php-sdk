<?php

namespace Casper\Types\Serializer;

use Casper\Types\TransactionTarget;

class TransactionTargetSerializer extends JsonSerializer
{
    /**
     * @param TransactionTarget $transactionTarget
     * @throws \Exception
     */
    public static function toJson($transactionTarget): string
    {
        if ($transactionTarget->isNative()) {
            return 'Native';
        }

        // TODO: Complete

        throw new \Exception('Unknown transactionTarget');
    }

    /**
     * @throws \Exception
     */
    public static function fromJson($json): TransactionTarget
    {
        if ($json === 'Native') {
            return new TransactionTarget(true, null, null);
        }

        // TODO: Complete

        throw new \Exception('Unknown transactionTarget');
    }
}
