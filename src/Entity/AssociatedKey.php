<?php

namespace Casper\Entity;

class AssociatedKey
{
    private string $accountHash;

    private int $weight;

    public function __construct(string $accountHash, int $weight)
    {
        $this->accountHash = $accountHash;
        $this->weight = $weight;
    }

    public function getAccountHash(): string
    {
        return $this->accountHash;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }
}
