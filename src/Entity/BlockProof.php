<?php

namespace Casper\Entity;

use Casper\CLType\CLPublicKey;

class BlockProof
{
    private CLPublicKey $publicKey;

    private string $signature; // Hash

    public function __construct(CLPublicKey $publicKey, string $signature)
    {
        $this->publicKey = $publicKey;
        $this->signature = $signature;
    }

    public function getPublicKey(): CLPublicKey
    {
        return $this->publicKey;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }
}
