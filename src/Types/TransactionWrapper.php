<?php

namespace Casper\Types;

class TransactionWrapper
{
    private ?Deploy $deploy;

    private ?TransactionV1 $transactionV1;

    public function __construct(?Deploy $deploy, ?TransactionV1 $transactionV1)
    {
        $this->deploy = $deploy;
        $this->transactionV1 = $transactionV1;
    }

    public function getDeploy(): ?Deploy
    {
        return $this->deploy;
    }

    public function getTransactionV1(): ?TransactionV1
    {
        return $this->transactionV1;
    }
}
