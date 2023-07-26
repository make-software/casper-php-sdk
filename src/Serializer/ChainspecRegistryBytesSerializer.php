<?php

namespace Casper\Serializer;

use Casper\Entity\ChainspecRegistryBytes;

class ChainspecRegistryBytesSerializer extends JsonSerializer
{
    /**
     * @param ChainspecRegistryBytes $chainspecRegistryBytes
     */
    public static function toJson($chainspecRegistryBytes): array
    {
        return array(
            'chainspec_bytes' => $chainspecRegistryBytes->getChainspecBytes(),
            'maybe_genesis_accounts_bytes' => $chainspecRegistryBytes->getGenesisAccountsBytes(),
            'maybe_global_state_bytes' => $chainspecRegistryBytes->getGlobalStateBytes(),
        );
    }

    public static function fromJson(array $json): ChainspecRegistryBytes
    {
        return new ChainspecRegistryBytes(
            $json['chainspec_bytes'],
            $json['maybe_genesis_accounts_bytes'],
            $json['maybe_global_state_bytes']
        );
    }
}
