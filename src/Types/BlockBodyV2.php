<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLPublicKey;

class BlockBodyV2
{
    /**
     * @var BlockTransaction[]
     */
    private array $transactions;

    /**
     * @var int[]
     */
    private array $rewardedSignatures;

    public function __construct(array $transactions, array $rewardedSignatures)
    {
        $this->transactions = $transactions;
        $this->rewardedSignatures = $rewardedSignatures;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function getRewardedSignatures(): array
    {
        return $this->rewardedSignatures;
    }
}
