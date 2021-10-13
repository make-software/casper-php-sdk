<?php

namespace Casper\Entity;

use Casper\CLType\CLPublicKey;

class SeigniorageAllocationValidator
{
    private CLPublicKey $validatorPublicKey;

    private \GMP $amount;

    public function __construct(CLPublicKey $validatorPublicKey, \GMP $amount)
    {
        $this->validatorPublicKey = $validatorPublicKey;
        $this->amount = $amount;
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
