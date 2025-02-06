<?php

namespace Casper\Types;

class ChainspecBytes
{
    private string $chainspecBytes;

    private ?string $genesisAccountsBytes;

    private ?string $globalStateBytes;

    public function __construct(
        string  $chainspecBytes,
        ?string $genesisAccountsBytes,
        ?string $globalStateBytes
    )
    {
        $this->chainspecBytes = $chainspecBytes;
        $this->genesisAccountsBytes = $genesisAccountsBytes;
        $this->globalStateBytes = $globalStateBytes;
    }

    public function getChainspecBytes(): string
    {
        return $this->chainspecBytes;
    }

    public function getGenesisAccountsBytes(): ?string
    {
        return $this->genesisAccountsBytes;
    }

    public function getGlobalStateBytes(): ?string
    {
        return $this->globalStateBytes;
    }
}
