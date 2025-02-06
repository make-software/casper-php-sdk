<?php

namespace Casper\Types;

class PayloadFields
{
    /**
     * @var NamedArg[]
     */
    private array $args;

    private string $entryPoint;

    private string $scheduling;

    private TransactionTarget $target;

    public function __construct(array $args, string $entryPoint, string $scheduling, TransactionTarget $target)
    {
        $this->args = $args;
        $this->entryPoint = $entryPoint;
        $this->scheduling = $scheduling;
        $this->target = $target;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function getEntryPoint(): string
    {
        return $this->entryPoint;
    }

    public function getScheduling(): string
    {
        return $this->scheduling;
    }

    public function getTarget(): TransactionTarget
    {
        return $this->target;
    }
}
