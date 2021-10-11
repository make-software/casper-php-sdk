<?php

namespace Casper\Entity;

class Transfer
{
    private string $deployHash;

    private string $from;

    private ?string $to;

    private string $source;

    private string $target;

    private \GMP $amount;

    private \GMP $gas;

    private ?int $id;

    public function __construct(
        string $deployHash,
        string $from,
        ?string $to,
        string $source,
        string $target,
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

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): ?string
    {
        return $this->to;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getTarget(): string
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
