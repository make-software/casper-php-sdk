<?php

namespace Casper\Entity;

class ValidatorWeight
{
    private string $publicKey;

    private \GMP $weight;

    public function __construct(string $publicKey, \GMP $weight)
    {
        $this->publicKey = $publicKey;
        $this->weight = $weight;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getWeight(): \GMP
    {
        return $this->weight;
    }
}
