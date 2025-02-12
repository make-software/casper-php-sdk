<?php

namespace Casper\Types\Serializer;

use Casper\Types\BlockTransaction;

class BlockTransactionSerializer extends JsonSerializer
{
    /**
     * @param BlockTransaction $blockTransaction
     */
    public static function toJson($blockTransaction): array
    {
        return array(
            'category' => $blockTransaction->getCategory(),
            $blockTransaction->getVersion() => $blockTransaction->getHash()
        );
    }

    public static function fromJson(array $json): BlockTransaction
    {
        return new BlockTransaction(
            $json['category'],
            array_key_exists(BlockTransaction::VERSION_DEPLOY, $json) ? BlockTransaction::VERSION_DEPLOY : BlockTransaction::VERSION_V1,
            $json[BlockTransaction::VERSION_DEPLOY] ?? $json[BlockTransaction::VERSION_V1]
        );
    }
}
