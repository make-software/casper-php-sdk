<?php

namespace Casper\Types;

class DeployExecutionResult
{
    private string $blockHash;

    private ExecutionResultV1 $result;

    public function __construct(string $blockHash, ExecutionResultV1 $result)
    {
        $this->blockHash = $blockHash;
        $this->result = $result;
    }

    public function getBlockHash(): string
    {
        return $this->blockHash;
    }

    public function getResult(): ExecutionResultV1
    {
        return $this->result;
    }
}
