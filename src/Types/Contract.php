<?php

namespace Casper\Types;

class Contract
{
    private string $contractPackageHash; // HashWithPrefix -> ContractPackageHash

    private string $contractWasmHash; // HashWithPrefix -> ContractWasmHash

    private string $protocolVersion; // Version

    /**
     * @var EntryPoint[]
     */
    private array $entryPoints;

    private array $namedKeys;

    /**
     * @throws \Exception
     */
    public function __construct(
        string $contractPackageHash,
        string $contractWasmHash,
        string $protocolVersion,
        array $entryPoints,
        array $namedKeys
    )
    {
        $this->contractPackageHash = $contractPackageHash;
        $this->contractWasmHash = $contractWasmHash;
        $this->protocolVersion = $protocolVersion;
        $this->entryPoints = $entryPoints;
        $this->namedKeys = $namedKeys;
    }

    public function getContractPackageHash(): string
    {
        return $this->contractPackageHash;
    }

    public function getContractWasmHash(): string
    {
        return $this->contractWasmHash;
    }

    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    public function getEntryPoints(): array
    {
        return $this->entryPoints;
    }

    public function getNamedKeys(): array
    {
        return $this->namedKeys;
    }
}
