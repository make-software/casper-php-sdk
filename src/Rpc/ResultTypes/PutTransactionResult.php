<?php

namespace Casper\Rpc\ResultTypes;

class PutTransactionResult extends AbstractResult
{
    private string $transactionHash;

    public static function fromJSON(array $json): self
    {
        return new self($json, $json['transaction_hash']);
    }

    public function __construct(array $rawJSON, string $transactionHash)
    {
        parent::__construct($rawJSON);
        $this->transactionHash = $transactionHash;
    }

    public function getTransactionHash(): string
    {
        return $this->transactionHash;
    }
}
