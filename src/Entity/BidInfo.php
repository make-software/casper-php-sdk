<?php

namespace Casper\Entity;

class BidInfo
{
    private string $bondingPurse;

    private \GMP $stakedAmount;

    private int $delegationRate;

    /**
     * @var Delegator[]
     */
    private array $delegators;

    private bool $inactive;

    /**
     * @param string $bondingPurse
     * @param \GMP $stakedAmount
     * @param int $delegationRate
     * @param Delegator[] $delegators
     * @param bool $inactive
     */
    public function __construct(
        string $bondingPurse,
        \GMP $stakedAmount,
        int $delegationRate,
        array $delegators,
        bool $inactive
    )
    {
        $this->bondingPurse = $bondingPurse;
        $this->stakedAmount = $stakedAmount;
        $this->delegationRate = $delegationRate;
        $this->delegators = $delegators;
        $this->inactive = $inactive;
    }

    public function getBondingPurse(): string
    {
        return $this->bondingPurse;
    }

    public function getStakedAmount(): \GMP
    {
        return $this->stakedAmount;
    }

    public function getDelegationRate(): int
    {
        return $this->delegationRate;
    }

    /**
     * @return Delegator[]
     */
    public function getDelegators(): array
    {
        return $this->delegators;
    }

    public function isInactive(): bool
    {
        return $this->inactive;
    }
}
