<?php

namespace Casper\Types;

class BlockWrapper
{
    private ?BlockV1 $blockV1;

    private ?BlockV2 $blockV2;

    public function __construct(?BlockV1 $blockV1, ?BlockV2 $blockV2)
    {
        $this->blockV1 = $blockV1;
        $this->blockV2 = $blockV2;
    }

    public function getBlockV1(): ?BlockV1
    {
        return $this->blockV1;
    }

    public function getBlockV2(): ?BlockV2
    {
        return $this->blockV2;
    }
}
