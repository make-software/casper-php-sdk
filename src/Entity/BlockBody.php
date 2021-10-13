<?php

namespace Casper\Entity;

use Casper\CLType\CLPublicKey;

class BlockBody
{
    private CLPublicKey $proposer;

    private array $deployHashes; // Hash[]

    private array $transferHashes; // Hash[]

    public function __construct(CLPublicKey $proposer, array $deployHashes, array $transferHashes)
    {
        $this->proposer = $proposer;
        $this->deployHashes = $deployHashes;
        $this->transferHashes = $transferHashes;
    }

    public function getProposer(): CLPublicKey
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
