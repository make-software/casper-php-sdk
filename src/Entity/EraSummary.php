<?php

namespace Casper\Entity;

class EraSummary
{
    private string $blockHash;

    private int $eraId;

    private StoredValue $storedValue;

    private string $stateRootHash;

    public function __construct(string $blockHash, int $eraId, StoredValue $storedValue, string $stateRootHash)
    {
        $this->blockHash = $blockHash;
        $this->eraId = $eraId;
        $this->storedValue = $storedValue;
        $this->stateRootHash = $stateRootHash;
    }

    public function getBlockHash(): string
    {
        return $this->blockHash;
    }

    public function getEraId(): int
    {
        return $this->eraId;
    }

    public function getStoredValue(): StoredValue
    {
        return $this->storedValue;
    }

    public function getStateRootHash(): string
    {
        return $this->stateRootHash;
    }
}
