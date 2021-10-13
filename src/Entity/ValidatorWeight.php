<?php

namespace Casper\Entity;

use Casper\CLType\CLPublicKey;

class ValidatorWeight
{
    private CLPublicKey $publicKey;

    private \GMP $weight;

    public function __construct(CLPublicKey $publicKey, \GMP $weight)
    {
        $this->publicKey = $publicKey;
        $this->weight = $weight;
    }

    public function getPublicKey(): CLPublicKey
    {
        return $this->publicKey;
    }

    public function getWeight(): \GMP
    {
        return $this->weight;
    }
}
