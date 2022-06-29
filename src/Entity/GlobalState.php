<?php

namespace Casper\Entity;

class GlobalState
{
    private BlockHeader $blockHeader;

    private StoredValue $storedValue;

    public function __construct(BlockHeader $blockHeader, StoredValue $storedValue)
    {
        $this->blockHeader = $blockHeader;
        $this->storedValue = $storedValue;
    }

    public function getBlockHeader(): BlockHeader
    {
        return $this->blockHeader;
    }

    public function getStoredValue(): StoredValue
    {
        return $this->storedValue;
    }
}
