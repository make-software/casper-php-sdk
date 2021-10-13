<?php

namespace Casper\Entity;

class Block
{
    private string $hash; // Hash

    private BlockHeader $header;

    private BlockBody $body;

    /**
     * @var BlockProof[]
     */
    private array $proofs;

    // $hash can be string or Hash
    public function __construct(string $hash, BlockHeader $header, BlockBody $body, array $proofs)
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

    public function getHeader(): BlockHeader
    {
        return $this->header;
    }

    public function getBody(): BlockBody
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
