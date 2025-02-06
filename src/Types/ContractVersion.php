<?php

namespace Casper\Types;

class ContractVersion
{
    private int $protocolVersionMajor;

    private int $contractVersion;

    private string $contractHash; // Hash

    public function __construct(int $protocolVersionMajor, int $contractVersion, string $contractHash)
    {
        $this->protocolVersionMajor = $protocolVersionMajor;
        $this->contractVersion = $contractVersion;
        $this->contractHash = $contractHash;
    }

    public function getProtocolVersionMajor(): int
    {
        return $this->protocolVersionMajor;
    }

    public function getContractVersion(): int
    {
        return $this->contractVersion;
    }

    public function getContractHash(): string
    {
        return $this->contractHash;
    }
}
