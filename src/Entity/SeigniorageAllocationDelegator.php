<?php

namespace Casper\Entity;

class SeigniorageAllocationDelegator
{
    private string $delegatorPublicKey;

    private string $validatorPublicKey;

    private \GMP $amount;

    public function __construct(string $delegatorPublicKey, string $validatorPublicKey, \GMP $amount)
    {
        $this->delegatorPublicKey = $delegatorPublicKey;
        $this->validatorPublicKey = $validatorPublicKey;
        $this->amount = $amount;
    }

    public function getDelegatorPublicKey(): string
    {
        return $this->delegatorPublicKey;
    }

    public function getValidatorPublicKey(): string
    {
        return $this->validatorPublicKey;
    }

    public function getAmount(): \GMP
    {
        return $this->amount;
    }
}
