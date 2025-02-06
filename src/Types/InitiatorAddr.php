<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLAccountHash;
use Casper\Types\CLValue\CLPublicKey;

class InitiatorAddr
{
    private ?CLPublicKey $publicKey;

    private ?CLAccountHash $accountHash;

    public function __construct(?CLPublicKey $publicKey, ?CLAccountHash $accountHash)
    {
        $this->publicKey = $publicKey;
        $this->accountHash = $accountHash;
    }

    public function getPublicKey(): ?CLPublicKey
    {
        return $this->publicKey;
    }

    public function getAccountHash(): ?CLAccountHash
    {
        return $this->accountHash;
    }
}
