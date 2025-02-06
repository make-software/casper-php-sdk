<?php

namespace Casper\Types;

class ExecutionInfo
{
    private string $blockHash;

    private int $blockHeight;

    private ExecutionResult $executionResult;

    public function __construct(string $blockHash, int $blockHeight, ExecutionResult $executionResult)
    {
        $this->blockHash = $blockHash;
        $this->blockHeight = $blockHeight;
        $this->executionResult = $executionResult;
    }

    public function getBlockHash(): string
    {
        return $this->blockHash;
    }

    public function getBlockHeight(): int
    {
        return $this->blockHeight;
    }

    public function getExecutionResult(): ExecutionResult
    {
        return $this->executionResult;
    }
}
