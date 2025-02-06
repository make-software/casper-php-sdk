<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\ExecutionResult;
use Casper\Types\Serializer\ExecutionResultSerializer;

class SpeculativeExecResult extends AbstractResult
{
    private string $blockHash;

    private ExecutionResult $executionResult;

    public static function fromJSON(array $json): self
    {
        return new self($json, $json['block_hash'], ExecutionResultSerializer::fromJson($json['execution_result']));
    }

    public function __construct(array $rawJSON, string $blockHash, ExecutionResult $executionResult)
    {
        parent::__construct($rawJSON);
        $this->blockHash = $blockHash;
        $this->executionResult = $executionResult;
    }

    public function getBlockHash(): string
    {
        return $this->blockHash;
    }

    public function getExecutionResult(): ExecutionResult
    {
        return $this->executionResult;
    }
}
