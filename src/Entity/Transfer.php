<?php

namespace Casper\Entity;

use Casper\CLType\CLAccountHash;
use Casper\CLType\CLURef;

class Transfer
{
    private string $deployHash; // Hash

    private CLAccountHash $from;

    private ?CLAccountHash $to;

    private CLURef $source;

    private CLURef $target;

    private \GMP $amount;

    private \GMP $gas;

    private ?int $id;

    public function __construct(
        string $deployHash,
        CLAccountHash $from,
        ?CLAccountHash $to,
        CLURef $source,
        CLURef $target,
        \GMP $amount,
        \GMP $gas,
        ?int $id
    )
    {
        $this->deployHash = $deployHash;
        $this->from = $from;
        $this->to = $to;
        $this->source = $source;
        $this->target = $target;
        $this->amount = $amount;
        $this->gas = $gas;
        $this->id = $id;
    }

    public function getDeployHash(): string
    {
        return $this->deployHash;
    }

    public function getFrom(): CLAccountHash
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
}
