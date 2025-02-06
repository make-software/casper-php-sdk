<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\Deploy;
use Casper\Types\ExecutionInfo;
use Casper\Types\DeployExecutionResult;
use Casper\Types\Serializer\ExecutionInfoSerializer;
use Casper\Types\Serializer\DeployExecutionResultSerializer;
use Casper\Types\Serializer\DeploySerializer;

class InfoGetDeployResult extends AbstractResult
{
    private Deploy $deploy;

    private ExecutionInfo $executionResults;

    /**
     * @var DeployExecutionResult[]
     */
    private ?array $executionResultsV1;

    /**
     * @throws \Exception
     */
    public static function fromJSON(array $json): self
    {
        return new self(
            $json,
            DeploySerializer::fromJson($json['deploy']),
            ExecutionInfoSerializer::fromJSON($json['execution_info']),
            isset($json['execution_results']) ? DeployExecutionResultSerializer::fromJsonArray($json['execution_results']) : null
        );
    }

    public function __construct(
        array $rawJSON,
        Deploy $deploy,
        ExecutionInfo $executionResults,
        ?array $executionResultsV1
    )
    {
        parent::__construct($rawJSON);
        $this->deploy = $deploy;
        $this->executionResults = $executionResults;
        $this->executionResultsV1 = $executionResultsV1;
    }

    public function getDeploy(): Deploy
    {
        return $this->deploy;
    }

    public function getExecutionResults(): ExecutionInfo
    {
        return $this->executionResults;
    }

    public function getExecutionResultsV1(): ?array
    {
        return $this->executionResultsV1;
    }
}
