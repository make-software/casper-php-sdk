<?php

namespace Casper\Types;

class ExecutionResultStatusData
{
    private string $status;

    private Effect $effect;

    /**
     * @var Transfer[]
     */
    private array $transfers;

    private \GMP $cost;

    private ?string $errorMessage = null;

    public function __construct(string $status, Effect $effect, array $transfers, \GMP $cost, ?string $errorMessage)
    {
        $this->status = $status;
        $this->effect = $effect;
        $this->transfers = $transfers;
        $this->cost = $cost;
        $this->errorMessage = $errorMessage;
    }

    public function getStatus(): string
    {
        return $this->status;
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
