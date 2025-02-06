<?php

namespace Casper\Types;

class AuctionState
{
    private string $stateRootHash;

    private int $blockHeight;

    /**
     * @var EraValidator[]
     */
    private array $eraValidators;

    /**
     * @var Bid[]
     */
    private array $bids;

    /**
     * @param string $stateRootHash
     * @param int $blockHeight
     * @param EraValidator[] $eraValidators
     * @param Bid[] $bids
     */
    public function __construct(string $stateRootHash, int $blockHeight, array $eraValidators, array $bids)
    {
        $this->stateRootHash = $stateRootHash;
        $this->blockHeight = $blockHeight;
        $this->eraValidators = $eraValidators;
        $this->bids = $bids;
    }

    public function getStateRootHash(): string
    {
        return $this->stateRootHash;
    }

    public function getBlockHeight(): int
    {
        return $this->blockHeight;
    }

    public function getEraValidators(): array
    {
        return $this->eraValidators;
    }

    public function getBids(): array
    {
        return $this->bids;
    }
}
