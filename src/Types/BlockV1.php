<?php

namespace Casper\Types;

class BlockV1
{
    private string $hash; // Hash

    private BlockHeaderV1 $header;

    private BlockBodyV1 $body;

    /**
     * @var BlockProof[]
     */
    private array $proofs;

    // $hash can be string or Hash
    public function __construct(string $hash, BlockHeaderV1 $header, BlockBodyV1 $body, array $proofs)
    {
        $this->hash = $hash;
        $this->header = $header;
        $this->body = $body;
        $this->proofs = $proofs;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getHeader(): BlockHeaderV1
    {
        return $this->header;
    }

    public function getBody(): BlockBodyV1
    {
        return $this->body;
    }

    /**
     * @return BlockProof[]
     */
    public function getProofs(): array
    {
        return $this->proofs;
    }
}
