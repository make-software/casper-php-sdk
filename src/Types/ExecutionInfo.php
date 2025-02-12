<?php

namespace Casper\Types;

class ExecutionInfo
{
    private string $blockHash;

    private int $blockHeight;

    private ExecutionResult $executionResult;

    /**
     * @param DeployExecutionResult[] $deployExecutionResults
     * @param int|null $blockHeight
     * @param InitiatorAddr|null $initiatorAddr
     * @return self
     * @throws \Exception
     */
    public static function fromV1(
        array $deployExecutionResults,
        ?int $blockHeight,
        ?InitiatorAddr $initiatorAddr = null
    ): self
    {
        if (count($deployExecutionResults) === 0) {
            throw new \Exception('Missing execution results');
        }

        return new self(
            $deployExecutionResults[0]->getBlockHash(),
            $blockHeight ?? 0,
            ExecutionResult::fromV1($deployExecutionResults[0]->getResult(), $initiatorAddr)
        );
    }

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
