<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLPublicKey;

class BlockHeader extends BlockHeaderV1
{
    private \GMP $currentGasPrice;

    private ?CLPublicKey $proposer;

    private ?BlockHeaderV1 $originBlockHeaderV1;

    private ?BlockHeaderV2 $originBlockHeaderV2;

    public static function newBlockHeaderFromV1(BlockHeaderV1 $headerV1): self
    {
        return new self(
            $headerV1->getParentHash(),
            $headerV1->getStateRootHash(),
            $headerV1->getBodyHash(),
            $headerV1->isRandomBit(),
            $headerV1->getAccumulatedSeed(),
            $headerV1->getEraEnd(),
            $headerV1->getTimestamp(),
            $headerV1->getEraId(),
            $headerV1->getHeight(),
            $headerV1->getProtocolVersion(),
            gmp_init(1),
            null,
            $headerV1,
            null
        );
    }

    public static function newBlockHeaderFromV2(BlockHeaderV2 $headerV2): self
    {
        return new self(
            $headerV2->getParentHash(),
            $headerV2->getStateRootHash(),
            $headerV2->getBodyHash(),
            $headerV2->isRandomBit(),
            $headerV2->getAccumulatedSeed(),
            $headerV2->getEraEnd(),
            $headerV2->getTimestamp(),
            $headerV2->getEraId(),
            $headerV2->getHeight(),
            $headerV2->getProtocolVersion(),
            $headerV2->getCurrentGasPrice(),
            $headerV2->getProposer(),
            null,
            $headerV2
        );
    }

    public function __construct(
        string $parentHash,
        string $stateRootHash,
        string $bodyHash,
        bool $randomBit,
        string $accumulatedSeed,
        ?EraEnd $eraEnd,
        int $timestamp,
        int $eraId,
        int $height,
        string $protocolVersion,
        \GMP $currentGasPrice,
        ?CLPublicKey $proposer,
        ?BlockHeaderV1 $originBlockHeaderV1,
        ?BlockHeaderV2 $originBlockHeaderV2
    )
    {
        parent::__construct($parentHash, $stateRootHash, $bodyHash, $randomBit, $accumulatedSeed, $eraEnd, $timestamp, $eraId, $height, $protocolVersion);
        $this->currentGasPrice = $currentGasPrice;
        $this->proposer = $proposer;
        $this->originBlockHeaderV1 = $originBlockHeaderV1;
        $this->originBlockHeaderV2 = $originBlockHeaderV2;
    }

    public function getCurrentGasPrice(): \GMP
    {
        return $this->currentGasPrice;
    }

    public function getProposer(): ?CLPublicKey
    {
        return $this->proposer;
    }

    public function getOriginBlockHeaderV1(): ?BlockHeaderV1
    {
        return $this->originBlockHeaderV1;
    }

    public function getOriginBlockHeaderV2(): ?BlockHeaderV2
    {
        return $this->originBlockHeaderV2;
    }
}
