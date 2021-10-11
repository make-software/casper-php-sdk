<?php

namespace Casper\Entity;

class DeployInfo
{
    private string $deployHash;

    private string $from;

    private string $source;

    private string $gas;

    /**
     * @var string[]
     */
    private array $transfers;

    public function __construct(string $deployHash, string $from, string $source, string $gas, array $transfers)
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

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getGas(): string
    {
        return $this->gas;
    }

    public function getTransfers(): array
    {
        return $this->transfers;
    }
}
