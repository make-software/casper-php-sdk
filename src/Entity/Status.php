<?php

namespace Casper\Entity;

class Status
{
    private string $chainspecName;

    private string $startingStateRootHash;

    private BlockInfo $lastAddedBlockInfo;

    private string $ourPublicSigningKey;

    private ?int $roundLength;

    private string $buildVersion;

    private ?array $nextUpgrade;

    /**
     * @var Peer[]
     */
    private array $peers;

    /**
     * @param string $chainspecName
     * @param string $startingStateRootHash
     * @param BlockInfo $lastAddedBlockInfo
     * @param string $ourPublicSigningKey
     * @param int|null $roundLength
     * @param string $buildVersion
     * @param array|null $nextUpgrade
     * @param Peer[] $peers
     */
    public function __construct(
        string $chainspecName,
        string $startingStateRootHash,
        BlockInfo $lastAddedBlockInfo,
        string $ourPublicSigningKey,
        ?int $roundLength,
        string $buildVersion,
        ?array $nextUpgrade,
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

    public function getOurPublicSigningKey(): string
    {
        return $this->ourPublicSigningKey;
    }

    public function getRoundLength(): ?int
    {
        return $this->roundLength;
    }

    public function getBuildVersion(): string
    {
        return $this->buildVersion;
    }

    public function getNextUpgrade(): ?array
    {
        return $this->nextUpgrade;
    }

    public function getPeers(): array
    {
        return $this->peers;
    }
}
