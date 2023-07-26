<?php

namespace Casper\Entity;

class DeployExecutionResult
{
    private string $blockHash;

    private DeployExecutionResultData $data;

    public function __construct(string $blockHash, DeployExecutionResultData $data)
    {
        $this->blockHash = $blockHash;
        $this->data = $data;
    }

    public function getBlockHash(): string
    {
        return $this->blockHash;
    }

    public function getData(): DeployExecutionResultData
    {
        return $this->data;
    }
}
