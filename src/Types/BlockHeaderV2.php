<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLPublicKey;

class BlockHeaderV2 extends BlockHeaderV1
{
    private \GMP $currentGasPrice;

    private CLPublicKey $proposer;

    private string $lastSwitchBlockHash;

    public function __construct(
        string $parentHash,
        string $stateRootHash,
        string $bodyHash,
        bool $randomBit,
        string $accumulatedSeed,
        ?EraEnd $eraEnd,
        int $timestamp,
        int $eraId,
        int $height,
        string $protocolVersion,
        \GMP $currentGasPrice,
        CLPublicKey $proposer,
        string $lastSwitchBlockHash
    )
    {
        parent::__construct(
            $parentHash,
            $stateRootHash,
            $bodyHash,
            $randomBit,
            $accumulatedSeed,
            $eraEnd,
            $timestamp,
            $eraId,
            $height,
            $protocolVersion
        );

        $this->currentGasPrice = $currentGasPrice;
        $this->proposer = $proposer;
        $this->lastSwitchBlockHash = $lastSwitchBlockHash;
    }

    public function getCurrentGasPrice(): \GMP
    {
        return $this->currentGasPrice;
    }

    public function getProposer(): CLPublicKey
    {
        return $this->proposer;
    }

    public function getLastSwitchBlockHash(): string
    {
        return $this->lastSwitchBlockHash;
    }
}
