<?php

namespace Casper\Types;

class TransactionHash
{
    private ?string $deploy;

    private ?string $transactionV1;

    public function __construct(?string $deploy, ?string $transactionV1)
    {
        $this->deploy = $deploy;
        $this->transactionV1 = $transactionV1;
    }

    public function getDeploy(): ?string
    {
        return $this->deploy;
    }

    public function getTransactionV1(): ?string
    {
        return $this->transactionV1;
    }
}
