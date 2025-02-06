<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\MinimalBlockInfo;
use Casper\Types\NextUpgrade;
use Casper\Types\Peer;
use Casper\Types\Serializer\MinimalBlockInfoSerializer;
use Casper\Types\Serializer\NextUpgradeSerializer;
use Casper\Types\Serializer\PeerSerializer;

class InfoGetStatusResult extends AbstractResult
{
    private string $protocolVersion;

    private string $buildVersion;

    private string $chainSpecName;

    private MinimalBlockInfo $lastAddedBlockInfo;

    private ?NextUpgrade $nextUpgrade;

    private string $outPublicSigningKey;

    /**
     * @var Peer[]
     */
    private array $peers;

    private string $roundLength;

    private string $startingStateRootHash;

    private string $uptime;

    private string $reactorState;

    private \DateTime $lastProgress;

    private string $latestSwitchBlockHash;

    private ?array $availableBlockRange;

    private array $blockSync;

    public static function fromJSON(array $json): self
    {
        return new self(
            $json,
            $json['protocol_version'],
            $json['build_version'],
            $json['chainspec_name'],
            MinimalBlockInfoSerializer::fromJSON($json['last_added_block_info']),
            $json['next_upgrade'] ? NextUpgradeSerializer::fromJSON($json['next_upgrade']) : null,
            $json['our_public_signing_key'],
            PeerSerializer::fromJsonArray($json['peers']),
            $json['round_length'],
            $json['starting_state_root_hash'],
            $json['uptime'],
            $json['reactor_state'],
            new \DateTime($json['last_progress']),
            $json['latest_switch_block_hash'],
            $json['available_block_ranges'],
            $json['block_sync']
        );
    }

    public function __construct(
        array $rawJSON,
        string $protocolVersion,
        string $buildVersion,
        string $chainSpecName,
        MinimalBlockInfo $lastAddedBlockInfo,
        ?NextUpgrade $nextUpgrade,
        string $outPublicSigningKey,
        array $peers,
        string $roundLength,
        string $startingStateRootHash,
        string $uptime,
        string $reactorState,
        \DateTime $lastProgress,
        string $latestSwitchBlockHash,
        ?array $availableBlockRange,
        array $blockSync
    )
    {
        parent::__construct($rawJSON);
        $this->protocolVersion = $protocolVersion;
        $this->buildVersion = $buildVersion;
        $this->chainSpecName = $chainSpecName;
        $this->lastAddedBlockInfo = $lastAddedBlockInfo;
        $this->nextUpgrade = $nextUpgrade;
        $this->outPublicSigningKey = $outPublicSigningKey;
        $this->peers = $peers;
        $this->roundLength = $roundLength;
        $this->startingStateRootHash = $startingStateRootHash;
        $this->uptime = $uptime;
        $this->reactorState = $reactorState;
        $this->lastProgress = $lastProgress;
        $this->latestSwitchBlockHash = $latestSwitchBlockHash;
        $this->availableBlockRange = $availableBlockRange;
        $this->blockSync = $blockSync;
    }

    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    public function getBuildVersion(): string
    {
        return $this->buildVersion;
    }

    public function getChainSpecName(): string
    {
        return $this->chainSpecName;
    }

    public function getLastAddedBlockInfo(): MinimalBlockInfo
    {
        return $this->lastAddedBlockInfo;
    }

    public function getNextUpgrade(): ?NextUpgrade
    {
        return $this->nextUpgrade;
    }

    public function getOutPublicSigningKey(): string
    {
        return $this->outPublicSigningKey;
    }

    public function getPeers(): array
    {
        return $this->peers;
    }

    public function getRoundLength(): string
    {
        return $this->roundLength;
    }

    public function getStartingStateRootHash(): string
    {
        return $this->startingStateRootHash;
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

    public function getLatestSwitchBlockHash(): string
    {
        return $this->latestSwitchBlockHash;
    }

    public function getAvailableBlockRange(): ?array
    {
        return $this->availableBlockRange;
    }

    public function getBlockSync(): array
    {
        return $this->blockSync;
    }
}
