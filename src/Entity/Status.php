<?php

namespace Casper\Entity;

use Casper\CLType\CLPublicKey;

class Status
{
    private string $chainspecName;

    private string $startingStateRootHash; // Hash

    private BlockInfo $lastAddedBlockInfo;

    private CLPublicKey $ourPublicSigningKey;

    private ?string $roundLength;

    private string $buildVersion;

    private ?NextUpgrade $nextUpgrade;

    /**
     * @var Peer[]
     */
    private array $peers;

    public function __construct(
        string $chainspecName,
        string $startingStateRootHash,
        BlockInfo $lastAddedBlockInfo,
        CLPublicKey $ourPublicSigningKey,
        ?string $roundLength,
        string $buildVersion,
        ?NextUpgrade $nextUpgrade,
        array $peers
    )
    {
        $this->chainspecName = $chainspecName;
        $this->startingStateRootHash = $startingStateRootHash;
        $this->lastAddedBlockInfo = $lastAddedBlockInfo;
        $this->ourPublicSigningKey = $ourPublicSigningKey;
        $this->roundLength = $roundLength;
        $this->buildVersion = $buildVersion;
        $this->nextUpgrade = $nextUpgrade;
        $this->peers = $peers;
    }

    public function getChainspecName(): string
    {
        return $this->chainspecName;
    }

    public function getStartingStateRootHash(): string
    {
        return $this->startingStateRootHash;
    }

    public function getLastAddedBlockInfo(): BlockInfo
    {
        return $this->lastAddedBlockInfo;
    }

    public function getOurPublicSigningKey(): CLPublicKey
    {
        return $this->ourPublicSigningKey;
    }

    public function getRoundLength(): ?string
    {
        return $this->roundLength;
    }

    public function getBuildVersion(): string
    {
        return $this->buildVersion;
    }

    public function getNextUpgrade(): ?NextUpgrade
    {
        return $this->nextUpgrade;
    }

    public function getPeers(): array
    {
        return $this->peers;
    }
}
