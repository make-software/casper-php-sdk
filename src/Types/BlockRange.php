<?php

namespace Casper\Types;

class BlockRange
{
    private int $low;

    private int $high;

    public function __construct(int $low, int $high)
    {
        $this->low = $low;
        $this->high = $high;
    }

    public function getLow(): int
    {
        return $this->low;
    }

    public function getHigh(): int
    {
        return $this->high;
    }
}
