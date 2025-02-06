<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLPublicKey;

class SeigniorageAllocationDelegator
{
    private CLPublicKey $delegatorPublicKey;

    private CLPublicKey $validatorPublicKey;

    private \GMP $amount;

    public function __construct(CLPublicKey $delegatorPublicKey, CLPublicKey $validatorPublicKey, \GMP $amount)
    {
        $this->delegatorPublicKey = $delegatorPublicKey;
        $this->validatorPublicKey = $validatorPublicKey;
        $this->amount = $amount;
    }

    public function getDelegatorPublicKey(): CLPublicKey
    {
        return $this->delegatorPublicKey;
    }

    public function getValidatorPublicKey(): CLPublicKey
    {
        return $this->validatorPublicKey;
    }

    public function getAmount(): \GMP
    {
        return $this->amount;
    }
}
