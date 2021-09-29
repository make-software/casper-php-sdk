<?php

namespace Casper\Entity;

class BlockProof
{
    private string $publicKey;

    private string $signature;

    public function __construct(string $publicKey, string $signature)
    {
        $this->publicKey = $publicKey;
        $this->signature = $signature;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }
}
