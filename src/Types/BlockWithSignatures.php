<?php

namespace Casper\Types;

class BlockWithSignatures
{
    private BlockWrapper $block;

    /**
     * @var BlockProof[]
     */
    private array $proofs;

    public function __construct(BlockWrapper $block, array $proofs)
    {
        $this->block = $block;
        $this->proofs = $proofs;
    }

    public function getBlock(): BlockWrapper
    {
        return $this->block;
    }

    public function getProofs(): array
    {
        return $this->proofs;
    }
}
