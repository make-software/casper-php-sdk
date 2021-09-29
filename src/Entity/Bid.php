<?php

namespace Casper\Entity;

class Bid
{
    private string $publicKey;

    private BidInfo $info;

    public function __construct(string $publicKey, BidInfo $info)
    {
        $this->publicKey = $publicKey;
        $this->info = $info;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getInfo(): BidInfo
    {
        return $this->info;
    }
}
