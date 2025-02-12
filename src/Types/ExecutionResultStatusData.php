<?php

namespace Casper\Types;

class ExecutionResultStatusData
{
    private Effect $effect;

    /**
     * @var Transfer[]
     */
    private array $transfers;

    private \GMP $cost;

    private ?string $errorMessage;

    public function __construct(Effect $effect, array $transfers, \GMP $cost, ?string $errorMessage = null)
    {
        $this->effect = $effect;
        $this->transfers = $transfers;
        $this->cost = $cost;
        $this->errorMessage = $errorMessage;
    }

    public function getEffect(): Effect
    {
        return $this->effect;
    }

    public function getTransfers(): array
    {
        return $this->transfers;
    }

    public function getCost(): \GMP
    {
        return $this->cost;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}
