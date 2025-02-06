<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\CLValue\CLU512;

class InfoGetRewardResult extends AbstractResult
{
    private int $delegationRate;

    private int $eraId;

    private CLU512 $rewardAmount;

    private string $switchBlockHash;

    public static function fromJSON(array $json): self
    {
        return new self(
            $json,
            $json['delegation_rate'],
            $json['era_id'],
            new CLU512($json['reward_amount']),
            $json['switch_block_hash']
        );
    }

    public function __construct(
        array $rawJSON,
        int $delegationRate,
        int $eraId,
        CLU512 $rewardAmount,
        string $switchBlockHash
    )
    {
        parent::__construct($rawJSON);
        $this->delegationRate = $delegationRate;
        $this->eraId = $eraId;
        $this->rewardAmount = $rewardAmount;
        $this->switchBlockHash = $switchBlockHash;
    }

    public function getDelegationRate(): int
    {
        return $this->delegationRate;
    }

    public function getEraId(): int
    {
        return $this->eraId;
    }

    public function getRewardAmount(): CLU512
    {
        return $this->rewardAmount;
    }

    public function getSwitchBlockHash(): string
    {
        return $this->switchBlockHash;
    }
}
