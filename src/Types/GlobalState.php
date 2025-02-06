<?php

namespace Casper\Types;

class GlobalState
{
    private ?BlockHeaderV1 $blockHeader;

    private StoredValue $storedValue;

    public function __construct(?BlockHeaderV1 $blockHeader, StoredValue $storedValue)
    {
        $this->blockHeader = $blockHeader;
        $this->storedValue = $storedValue;
    }

    public function getBlockHeader(): ?BlockHeaderV1
    {
        return $this->blockHeader;
    }

    public function getStoredValue(): StoredValue
    {
        return $this->storedValue;
    }
}
