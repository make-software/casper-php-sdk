<?php

namespace Casper\Types\CLValue;

class CLValueWithRemainder
{
    private CLValue $clValue;

    private array $remainder;

    public function __construct(CLValue $clValue, array $remainder = [])
    {
        $this->clValue = $clValue;
        $this->remainder = $remainder;
    }

    public function getClValue(): CLValue
    {
        return $this->clValue;
    }

    public function getRemainder(): array
    {
        return $this->remainder;
    }
}
