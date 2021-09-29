<?php

namespace Casper\Entity;

class Delegator
{
    private string $publicKey;

    private \GMP $stakedAmount;

    private string $bondingPurse;

    private string $delegatee;

    public function __construct(string $publicKey, \GMP $stakedAmount, string $bondingPurse, string $delegatee)
    {
        $this->publicKey = $publicKey;
        $this->stakedAmount = $stakedAmount;
        $this->bondingPurse = $bondingPurse;
        $this->delegatee = $delegatee;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getStakedAmount(): \GMP
    {
        return $this->stakedAmount;
    }

    public function getBondingPurse(): string
    {
        return $this->bondingPurse;
    }

    public function getDelegatee(): string
    {
        return $this->delegatee;
    }
}
