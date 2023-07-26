<?php

namespace Casper\Entity;

class DeployExecutionResult
{
    private string $blockHash;

    private DeployExecutionResultData $result;

    public function __construct(string $blockHash, DeployExecutionResultData $result)
    {
        $this->blockHash = $blockHash;
        $this->result = $result;
    }

    public function getBlockHash(): string
    {
        return $this->blockHash;
    }

    public function getResult(): DeployExecutionResultData
    {
        return $this->result;
    }
}
