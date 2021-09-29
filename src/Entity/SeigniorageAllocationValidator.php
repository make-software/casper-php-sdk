<?php

namespace Casper\Entity;

class SeigniorageAllocationValidator
{
    private string $validatorPublicKey;

    private \GMP $amount;

    public function __construct(string $validatorPublicKey, \GMP $amount)
    {
        $this->validatorPublicKey = $validatorPublicKey;
        $this->amount = $amount;
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
