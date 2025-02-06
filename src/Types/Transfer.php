<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLAccountHash;
use Casper\Types\CLValue\CLURef;

class Transfer
{
    private TransactionHash $transactionHash;

    private InitiatorAddr $from;

    private ?CLAccountHash $to;

    private CLURef $source;

    private CLURef $target;

    private \GMP $amount;

    private \GMP $gas;

    private ?int $id;

    private ?TransferV1 $originalTransferV1;

    private ?TransferV2 $originalTransferV2;

    public function __construct(
        TransactionHash $transactionHash,
        InitiatorAddr $from,
        ?CLAccountHash $to,
        CLURef $source,
        CLURef $target,
        \GMP $amount,
        \GMP $gas,
        ?int $id,
        ?TransferV1 $originalTransferV1 = null,
        ?TransferV2 $originalTransferV2 = null
    )
    {
        $this->transactionHash = $transactionHash;
        $this->from = $from;
        $this->to = $to;
        $this->source = $source;
        $this->target = $target;
        $this->amount = $amount;
        $this->gas = $gas;
        $this->id = $id;
        $this->originalTransferV1 = $originalTransferV1;
        $this->originalTransferV2 = $originalTransferV2;
    }

    public function getTransactionHash(): TransactionHash
    {
        return $this->transactionHash;
    }

    public function getFrom(): InitiatorAddr
    {
        return $this->from;
    }

    public function getTo(): ?CLAccountHash
    {
        return $this->to;
    }

    public function getSource(): CLURef
    {
        return $this->source;
    }

    public function getTarget(): CLURef
    {
        return $this->target;
    }

    public function getAmount(): \GMP
    {
        return $this->amount;
    }

    public function getGas(): \GMP
    {
        return $this->gas;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginalTransferV1(): ?TransferV1
    {
        return $this->originalTransferV1;
    }

    public function getOriginalTransferV2(): ?TransferV2
    {
        return $this->originalTransferV2;
    }
}
