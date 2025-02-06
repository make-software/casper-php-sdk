<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLPublicKey;

class Block
{
    private string $hash;

    private int $height;

    private string $stateRootHash;

    private ?string $lastSwitchBlockHash;

    private string $parentHash;

    private int $eraId;

    private int $timestamp;

    private ?string $accumulatedSeed;

    private bool $randomBit;

    private \GMP $currentGasPrice;

    private CLPublicKey $proposer;

    private ?string $protocolVersion;

    private ?EraEnd $eraEnd;

    /** @var BlockTransaction[] */
    private array $transactions;

    /** @var int[]  */
    private array $rewardedSignatures;

    /** @var BlockProof[] */
    private array $proofs;

    private ?BlockV1 $originBlockV1;

    private ?BlockV2 $originBlockV2;

    /**
     * @throws \Exception
     */
    public static function newBlockFromBlockWrapper(BlockWrapper $blockWrapper, array $proofs): self
    {
        if ($blockWrapper->getBlockV1() !== null) {
            return self::newBlockFromBlockV1($blockWrapper->getBlockV1())
                ->setProofs($proofs);
        }
        else if ($blockWrapper->getBlockV2() !== null) {
            $blockV2 = $blockWrapper->getBlockV2();
            return new self(
                $blockV2->getHash(),
                $blockV2->getHeader()->getHeight(),
                $blockV2->getHeader()->getStateRootHash(),
                $blockV2->getHeader()->getLastSwitchBlockHash(),
                $blockV2->getHeader()->getParentHash(),
                $blockV2->getHeader()->getEraId(),
                $blockV2->getHeader()->getTimestamp(),
                $blockV2->getHeader()->getAccumulatedSeed(),
                $blockV2->getHeader()->isRandomBit(),
                $blockV2->getHeader()->getCurrentGasPrice(),
                $blockV2->getHeader()->getProposer(),
                $blockV2->getHeader()->getProtocolVersion(),
                $blockV2->getHeader()->getEraEnd(),
                $blockV2->getBody()->getTransactions(),
                $blockV2->getBody()->getRewardedSignatures(),
                $proofs,
                null,
                $blockV2
            );
        }

        throw new \Exception('BlockWrapper must contain either BlockV1 or BlockV2');
    }

    public static function newBlockFromBlockV1(BlockV1 $blockV1): self
    {
        $blockTransactions = [];
        foreach ($blockV1->getBody()->getTransferHashes() as $transferHash) {
            $blockTransactions[] = new BlockTransaction(
                BlockTransaction::CATEGORY_MINT,
                BlockTransaction::VERSION_DEPLOY,
                $transferHash
            );
        }

        foreach ($blockV1->getBody()->getDeployHashes() as $deployHash) {
            $blockTransactions[] = new BlockTransaction(
                BlockTransaction::CATEGORY_LARGE,
                BlockTransaction::VERSION_DEPLOY,
                $deployHash
            );
        }

        return new self(
            $blockV1->getHash(),
            $blockV1->getHeader()->getHeight(),
            $blockV1->getHeader()->getStateRootHash(),
            null,
            $blockV1->getHeader()->getParentHash(),
            $blockV1->getHeader()->getEraId(),
            $blockV1->getHeader()->getTimestamp(),
            $blockV1->getHeader()->getAccumulatedSeed(),
            $blockV1->getHeader()->isRandomBit(),
            gmp_init(1),
            $blockV1->getBody()->getProposer(),
            $blockV1->getHeader()->getProtocolVersion(),
            $blockV1->getHeader()->getEraEnd(),
            $blockTransactions,
            [],
            $blockV1->getProofs(),
            $blockV1,
            null
        );
    }

    public function __construct(
        string $hash,
        int $height,
        string $stateRootHash,
        string $lastSwitchBlockHash,
        string $parentHash,
        int $eraId,
        int $timestamp,
        string $accumulatedSeed,
        bool $randomBit,
        \GMP $currentGasPrice,
        CLPublicKey $proposer,
        string $protocolVersion,
        ?EraEnd $eraEnd,
        array $transactions,
        array $rewardedSignatures,
        array $proofs,
        ?BlockV1 $originBlockV1,
        ?BlockV2 $originBlockV2
    )
    {
        $this->hash = $hash;
        $this->height = $height;
        $this->stateRootHash = $stateRootHash;
        $this->lastSwitchBlockHash = $lastSwitchBlockHash;
        $this->parentHash = $parentHash;
        $this->eraId = $eraId;
        $this->timestamp = $timestamp;
        $this->accumulatedSeed = $accumulatedSeed;
        $this->randomBit = $randomBit;
        $this->currentGasPrice = $currentGasPrice;
        $this->proposer = $proposer;
        $this->protocolVersion = $protocolVersion;
        $this->eraEnd = $eraEnd;
        $this->transactions = $transactions;
        $this->rewardedSignatures = $rewardedSignatures;
        $this->proofs = $proofs;
        $this->originBlockV1 = $originBlockV1;
        $this->originBlockV2 = $originBlockV2;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getStateRootHash(): string
    {
        return $this->stateRootHash;
    }

    public function getLastSwitchBlockHash(): string
    {
        return $this->lastSwitchBlockHash;
    }

    public function getParentHash(): string
    {
        return $this->parentHash;
    }

    public function getEraId(): int
    {
        return $this->eraId;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getAccumulatedSeed(): string
    {
        return $this->accumulatedSeed;
    }

    public function isRandomBit(): bool
    {
        return $this->randomBit;
    }

    public function getCurrentGasPrice(): \GMP
    {
        return $this->currentGasPrice;
    }

    public function getProposer(): CLPublicKey
    {
        return $this->proposer;
    }

    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    public function getEraEnd(): ?EraEnd
    {
        return $this->eraEnd;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function getRewardedSignatures(): array
    {
        return $this->rewardedSignatures;
    }

    public function setProofs(array $proofs): self
    {
        $this->proofs = $proofs;
        return $this;
    }

    public function getProofs(): array
    {
        return $this->proofs;
    }

    public function getOriginBlockV1(): ?BlockV1
    {
        return $this->originBlockV1;
    }

    public function getOriginBlockV2(): ?BlockV2
    {
        return $this->originBlockV2;
    }
}
