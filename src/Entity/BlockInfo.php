<?php

namespace Casper\Entity;

use Casper\CLType\CLPublicKey;

class BlockInfo
{
    private string $hash; // Hash

    private int $timestamp;

    private int $eraId;

    private int $height;

    private string $stateRootHash; // Hash

    private CLPublicKey $creator;

    public function __construct(
        string $hash,
        int $timestamp,
        int $eraId,
        int $height,
        string $stateRootHash,
        CLPublicKey $creator
    )
    {
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

    public function getCreator(): CLPublicKey
    {
        return $this->creator;
    }
}
