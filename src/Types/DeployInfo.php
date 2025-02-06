<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLAccountHash;
use Casper\Types\CLValue\CLURef;

class DeployInfo
{
    private string $deployHash; // Hash

    private CLAccountHash $from;

    private CLURef $source;

    private \GMP $gas;

    private array $transfers;

    public function __construct(
        string $deployHash,
        CLAccountHash $from,
        CLURef $source,
        \GMP $gas,
        array $transfers
    )
    {
        $this->deployHash = $deployHash;
        $this->from = $from;
        $this->source = $source;
        $this->gas = $gas;
        $this->transfers = $transfers;
    }

    public function getDeployHash(): string
    {
        return $this->deployHash;
    }

    public function getFrom(): CLAccountHash
    {
        return $this->from;
    }

    public function getSource(): CLURef
    {
        return $this->source;
    }

    public function getGas(): \GMP
    {
        return $this->gas;
    }

    public function getTransfers(): array
    {
        return $this->transfers;
    }
}
