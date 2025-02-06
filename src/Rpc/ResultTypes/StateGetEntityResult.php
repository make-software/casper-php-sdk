<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\Serializer\AccountSerializer;

class StateGetEntityResult extends AbstractResult
{
    private $entity;

    private string $merkleProof;

    public static function fromJSON(array $json): self
    {
        $entity = null;
        if (isset($json['entity']['Account'])) {
            $entity = AccountSerializer::fromJson($json['entity']['Account']);
        }

        return new self($json, $entity, $json['merkle_proof']);
    }

    public function __construct(array $rawJSON, $entity, string $merkleProof)
    {
        parent::__construct($rawJSON);
        $this->entity = $entity;
        $this->merkleProof = $merkleProof;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getMerkleProof(): string
    {
        return $this->merkleProof;
    }
}
