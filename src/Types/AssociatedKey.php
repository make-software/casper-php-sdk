<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLAccountHash;

class AssociatedKey
{
    private CLAccountHash $accountHash;

    private int $weight;

    public function __construct(CLAccountHash $accountHash, int $weight)
    {
        $this->accountHash = $accountHash;
        $this->weight = $weight;
    }

    public function getAccountHash(): CLAccountHash
    {
        return $this->accountHash;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }
}
