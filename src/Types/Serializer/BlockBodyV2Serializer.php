<?php

namespace Casper\Types\Serializer;

use Casper\Types\BlockBodyV2;

class BlockBodyV2Serializer extends JsonSerializer
{
    /**
     * @param BlockBodyV2 $blockBodyV2
     */
    public static function toJson($blockBodyV2): array
    {
        return array(
            'transactions' => BlockTransactionSerializer::toJsonArray($blockBodyV2->getTransactions()),
            'rewarded_signatures' => $blockBodyV2->getRewardedSignatures(),
        );
    }

    public static function fromJson(array $json): BlockBodyV2
    {
        $transactionsData = [];
        foreach ($json['transactions'] as $category => $transactions) {
            foreach ($transactions as $transaction) {
                $transaction['category'] = $category;
                $transactionsData[] = $transaction;
            }
        }

        return new BlockBodyV2(
            BlockTransactionSerializer::fromJsonArray($transactionsData),
            $json['rewarded_signatures']
        );
    }
}
