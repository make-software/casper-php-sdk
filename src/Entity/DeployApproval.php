<?php

namespace Casper\Entity;

use Casper\CLType\CLPublicKey;

class DeployApproval
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
