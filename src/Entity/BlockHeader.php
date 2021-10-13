<?php

namespace Casper\Entity;

class BlockHeader
{
    private string $parentHash; // Hash

    private string $stateRootHash; // Hash

    private string $bodyHash; // Hash

    private bool $randomBit;

    private string $accumulatedSeed; // Hash

    private ?EraEnd $eraEnd;

    private int $timestamp;

    private int $eraId;

    private int $height;

    private string $protocolVersion; // Version

    public function __construct(
        string $parentHash,
        string $stateRootHash,
        string $bodyHash,
        bool $randomBit,
        string $accumulatedSeed,
        ?EraEnd $eraEnd,
        int $timestamp,
        int $eraId,
        int $height,
        string $protocolVersion
    )
    {
        $this->parentHash = $parentHash;
        $this->stateRootHash = $stateRootHash;
        $this->bodyHash = $bodyHash;
        $this->randomBit = $randomBit;
        $this->accumulatedSeed = $accumulatedSeed;
        $this->eraEnd = $eraEnd;
        $this->timestamp = $timestamp;
        $this->eraId = $eraId;
        $this->height = $height;
        $this->protocolVersion = $protocolVersion;
    }

    public function getParentHash(): string
    {
        return $this->parentHash;
    }

    public function getStateRootHash(): string
    {
        return $this->stateRootHash;
    }

    public function getBodyHash(): string
    {
        return $this->bodyHash;
    }

    public function isRandomBit(): bool
    {
        return $this->randomBit;
    }

    public function getAccumulatedSeed(): string
    {
        return $this->accumulatedSeed;
    }

    public function getEraEnd(): ?EraEnd
    {
        return $this->eraEnd;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getEraId(): int
    {
        return $this->eraId;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }
}
