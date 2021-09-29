<?php

namespace Casper\Entity;

class BlockInfo
{
    private string $hash;

    private int $timestamp;

    private int $eraId;

    private int $height;

    private string $stateRootHash;

    private string $creator;

    public function __construct(
        string $hash,
        int $timestamp,
        int $eraId,
        int $height,
        string $stateRootHash,
        string $creator
    ) {
        $this->hash = $hash;
        $this->timestamp = $timestamp;
        $this->eraId = $eraId;
        $this->height = $height;
        $this->stateRootHash = $stateRootHash;
        $this->creator = $creator;
    }

    public function getHash(): string
    {
        return $this->hash;
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

    public function getStateRootHash(): string
    {
        return $this->stateRootHash;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }
}
