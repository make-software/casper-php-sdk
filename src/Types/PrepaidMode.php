<?php

namespace Casper\Types;

class PrepaidMode
{
    private string $receipt;

    public function __construct(string $receipt)
    {
        $this->receipt = $receipt;
    }

    public function getReceipt(): string
    {
        return $this->receipt;
    }
}
