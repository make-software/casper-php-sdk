<?php

namespace Casper\Entity;

use Casper\Validation\EntityValidationAware;

class ContractMetadata
{
    use EntityValidationAware;

    private string $contractPackageHash;

    private string $contractWasmHash;

    private string $protocolVersion;

    /**
     * @var EntryPoint[]
     */
    private array $entryPoints;

    /**
     * @var NamedKey[]
     */
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
        $this->assertArrayContainsProperEntities($entryPoints, EntryPoint::class);
        $this->assertArrayContainsProperEntities($namedKeys, NamedKey::class);

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
