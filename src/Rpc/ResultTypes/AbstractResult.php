<?php

namespace Casper\Rpc\ResultTypes;

abstract class AbstractResult
{
    private array $rawJSON;

    private string $apiVersion;

    public function __construct(array $rawJSON)
    {
        $this->rawJSON = $rawJSON;
        $this->apiVersion = $rawJSON['api_version'];
    }

    public function getRawJSON(): array
    {
        return $this->rawJSON;
    }

    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }
}
