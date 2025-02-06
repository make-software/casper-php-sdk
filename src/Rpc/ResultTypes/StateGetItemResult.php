<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\Serializer\StoredValueSerializer;
use Casper\Types\StoredValue;

class StateGetItemResult extends AbstractResult
{
    private StoredValue $storedValue;

    private string $merkleProof;

    /**
     * @throws \Exception
     */
    public static function fromJSON(array $json): self
    {
        return new self($json, StoredValueSerializer::fromJson($json['stored_value']), $json['merkle_proof']);
    }

    public function __construct(array $rawJSON, StoredValue $storedValue, string $merkleProof)
    {
        parent::__construct($rawJSON);
        $this->storedValue = $storedValue;
        $this->merkleProof = $merkleProof;
    }

    public function getStoredValue(): StoredValue
    {
        return $this->storedValue;
    }

    public function getMerkleProof(): string
    {
        return $this->merkleProof;
    }
}
