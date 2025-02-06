<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLPublicKey;

class Reward
{
    private \GMP $amount;

    private CLPublicKey $validator;

    public function __construct(\GMP $amount, CLPublicKey $validator)
    {
        $this->amount = $amount;
        $this->validator = $validator;
    }

    public function getAmount(): \GMP
    {
        return $this->amount;
    }

    public function getValidator(): CLPublicKey
    {
        return $this->validator;
    }
}
