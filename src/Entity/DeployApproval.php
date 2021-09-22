<?php

namespace Casper\Entity;

class DeployApproval
{
    private string $signer;

    private string $signature;

    public function __construct(string $signer, string $signature)
    {
        $this->signer = $signer;
        $this->signature = $signature;
    }

    public function getSigner(): string
    {
        return $this->signer;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }
}
