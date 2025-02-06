<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\CLValue\CLURef;

class Delegator
{
    private CLPublicKey $publicKey;

    private \GMP $stakedAmount;

    private CLURef $bondingPurse;

    private CLPublicKey $delegatee;

    public function __construct(
        CLPublicKey $publicKey,
        \GMP $stakedAmount,
        CLURef $bondingPurse,
        CLPublicKey $delegatee
    )
    {
        $this->publicKey = $publicKey;
        $this->stakedAmount = $stakedAmount;
        $this->bondingPurse = $bondingPurse;
        $this->delegatee = $delegatee;
    }

    public function getPublicKey(): CLPublicKey
    {
        return $this->publicKey;
    }

    public function getStakedAmount(): \GMP
    {
        return $this->stakedAmount;
    }

    public function getBondingPurse(): CLURef
    {
        return $this->bondingPurse;
    }

    public function getDelegatee(): CLPublicKey
    {
        return $this->delegatee;
    }
}
