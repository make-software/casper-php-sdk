<?php

namespace Casper\Entity;

use Casper\CLType\CLPublicKey;

class Bid
{
    private CLPublicKey $publicKey;

    private BidInfo $info;

    public function __construct(CLPublicKey $publicKey, BidInfo $info)
    {
        $this->publicKey = $publicKey;
        $this->info = $info;
    }

    public function getPublicKey(): CLPublicKey
    {
        return $this->publicKey;
    }

    public function getInfo(): BidInfo
    {
        return $this->info;
    }
}
