<?php

namespace Casper\Types\Serializer;

use Casper\Types\ChainspecBytes;

class ChainspecBytesSerializer extends JsonSerializer
{
    /**
     * @param ChainspecBytes $chainspecBytes
     */
    public static function toJson($chainspecBytes): array
    {
        return array(
            'chainspec_bytes' => $chainspecBytes->getChainspecBytes(),
            'maybe_genesis_accounts_bytes' => $chainspecBytes->getGenesisAccountsBytes(),
            'maybe_global_state_bytes' => $chainspecBytes->getGlobalStateBytes(),
        );
    }

    public static function fromJson(array $json): ChainspecBytes
    {
        return new ChainspecBytes(
            $json['chainspec_bytes'],
            $json['maybe_genesis_accounts_bytes'],
            $json['maybe_global_state_bytes']
        );
    }
}
