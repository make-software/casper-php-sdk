<?php

namespace Casper\Rpc\ResultTypes;

class ChainGetStateRootHashResult extends AbstractResult
{
    private string $stateRootHash;

    public static function fromJSON(array $json): self
    {
        return new self($json, $json['state_root_hash']);
    }

    public function __construct(array $rawJSON, string $stateRootHash)
    {
        parent::__construct($rawJSON);
        $this->stateRootHash = $stateRootHash;
    }

    public function getStateRootHash(): string
    {
        return $this->stateRootHash;
    }
}
