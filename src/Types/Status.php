<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLPublicKey;

class Status
{
    private string $apiVersion;

    private string $chainspecName;

    private string $startingStateRootHash; // Hash

    private MinimalBlockInfo $lastAddedBlockInfo;

    private CLPublicKey $ourPublicSigningKey;

    private ?string $roundLength;

    private string $buildVersion;

    private ?NextUpgrade $nextUpgrade;

    private string $uptime;

    private string $reactorState;

    private \DateTime $lastProgress;

    private BlockRange $availableBlockRange;

    /**
     * @var Peer[]
     */
    private array $peers;

    public function __construct(
        string           $apiVersion,
        string           $chainspecName,
        string           $startingStateRootHash,
        MinimalBlockInfo $lastAddedBlockInfo,
        CLPublicKey      $ourPublicSigningKey,
        ?string          $roundLength,
        string           $buildVersion,
        ?NextUpgrade     $nextUpgrade,
        array            $peers,
        string           $uptime,
        string           $reactorState,
        \DateTime        $lastProgress,
        BlockRange       $availableBlockRange
    )
    {
        $this->apiVersion = $apiVersion;
        $this->chainspecName = $chainspecName;
        $this->startingStateRootHash = $startingStateRootHash;
        $this->lastAddedBlockInfo = $lastAddedBlockInfo;
        $this->ourPublicSigningKey = $ourPublicSigningKey;
        $this->roundLength = $roundLength;
        $this->buildVersion = $buildVersion;
        $this->nextUpgrade = $nextUpgrade;
        $this->peers = $peers;
        $this->uptime = $uptime;
        $this->reactorState = $reactorState;
        $this->lastProgress = $lastProgress;
        $this->availableBlockRange = $availableBlockRange;
    }

    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    public function getChainspecName(): string
    {
        return $this->chainspecName;
    }

    public function getStartingStateRootHash(): string
    {
        return $this->startingStateRootHash;
    }

    public function getLastAddedBlockInfo(): MinimalBlockInfo
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

    public function getUptime(): string
    {
        return $this->uptime;
    }

    public function getReactorState(): string
    {
        return $this->reactorState;
    }

    public function getLastProgress(): \DateTime
    {
        return $this->lastProgress;
    }

    public function getAvailableBlockRange(): BlockRange
    {
        return $this->availableBlockRange;
    }
}
