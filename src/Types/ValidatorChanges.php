<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLPublicKey;

class ValidatorChanges
{
    private CLPublicKey $publicKey;

    private array $statusChanges;

    public function __construct(CLPublicKey $publicKey, array $statusChanges)
    {
        $this->publicKey = $publicKey;
        $this->statusChanges = $statusChanges;
    }

    public function getPublicKey(): CLPublicKey
    {
        return $this->publicKey;
    }

    public function getStatusChanges(): array
    {
        return $this->statusChanges;
    }
}
