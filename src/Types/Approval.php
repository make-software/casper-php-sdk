<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLPublicKey;

class Approval
{
    private CLPublicKey $signer;

    private string $signature; // Hash

    public function __construct(CLPublicKey $signer, string $signature)
    {
        $this->signer = $signer;
        $this->signature = $signature;
    }

    public function getSigner(): CLPublicKey
    {
        return $this->signer;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }
}
