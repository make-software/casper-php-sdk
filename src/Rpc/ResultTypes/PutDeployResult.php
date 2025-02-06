<?php

namespace Casper\Rpc\ResultTypes;

class PutDeployResult extends AbstractResult
{
    private string $deployHash;

    public static function fromJSON(array $json): self
    {
        return self($json, $json['deploy_hash']);
    }

    public function __construct(array $rawJSON, string $deployHash)
    {
        parent::__construct($rawJSON);
        $this->deployHash = $deployHash;
    }

    public function getDeployHash(): string
    {
        return $this->deployHash;
    }
}
