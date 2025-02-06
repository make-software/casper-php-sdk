<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\Deploy;
use Casper\Types\DeployExecutionResult;
use Casper\Types\ExecutionInfo;
use Casper\Types\Serializer\DeployExecutionResultSerializer;
use Casper\Types\Serializer\DeploySerializer;
use Casper\Types\Serializer\ExecutionInfoSerializer;
use Casper\Types\Serializer\TransactionWrapperSerializer;
use Casper\Types\TransactionWrapper;

class InfoGetTransactionResultV1Compatible extends AbstractResult
{
    private ?TransactionWrapper $transaction;

    private ?Deploy $deploy;

    private ?ExecutionInfo $executionInfo;

    /**
     * @var DeployExecutionResult[]
     */
    private array $executionResults;

    private ?string $blockHash;

    private ?int $blockHeight;

    public static function fromJSON(array $json): self
    {
        return new self(
            $json,
            isset($json['transaction']) ? TransactionWrapperSerializer::fromJSON($json['transaction']) : null,
            isset($json['deploy']) ? DeploySerializer::fromJSON($json['deploy']) : null,
            isset($json['execution_info']) ? ExecutionInfoSerializer::fromJSON($json['execution_info']) : null,
            isset($json['execution_results']) ? DeployExecutionResultSerializer::fromJsonArray($json['execution_results']) : [],
            $json['block_hash'] ?? null,
            $json['block_height'] ?? null
        );
    }

    public function __construct(
        array $rawJSON,
        ?TransactionWrapper $transaction,
        ?Deploy $deploy,
        ?ExecutionInfo $executionInfo,
        array $executionResults,
        ?string $blockHash,
        ?int $blockHeight
    )
    {
        parent::__construct($rawJSON);
        $this->transaction = $transaction;
        $this->deploy = $deploy;
        $this->executionInfo = $executionInfo;
        $this->executionResults = $executionResults;
        $this->blockHash = $blockHash;
        $this->blockHeight = $blockHeight;
    }

    public function getTransaction(): ?TransactionWrapper
    {
        return $this->transaction;
    }

    public function getDeploy(): ?Deploy
    {
        return $this->deploy;
    }

    public function getExecutionInfo(): ?ExecutionInfo
    {
        return $this->executionInfo;
    }

    public function getExecutionResults(): array
    {
        return $this->executionResults;
    }

    public function getBlockHash(): ?string
    {
        return $this->blockHash;
    }

    public function getBlockHeight(): ?int
    {
        return $this->blockHeight;
    }
}
