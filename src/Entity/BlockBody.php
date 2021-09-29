<?php

namespace Casper\Entity;

class BlockBody
{
    private string $proposer;

    private array $deployHashes;

    private array $transferHashes;

    public function __construct(string $proposer, array $deployHashes, array $transferHashes)
    {
        $this->proposer = $proposer;
        $this->deployHashes = $deployHashes;
        $this->transferHashes = $transferHashes;
    }

    public function getProposer(): string
    {
        return $this->proposer;
    }

    public function getDeployHashes(): array
    {
        return $this->deployHashes;
    }

    public function getTransferHashes(): array
    {
        return $this->transferHashes;
    }
}
