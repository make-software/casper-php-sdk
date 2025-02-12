<?php

namespace Casper\Types;

use Casper\Types\Serializer\TransformSerializer;

class ExecutionResult
{
    private ?InitiatorAddr $initiatorAddr;

    private ?string $errorMessage;

    private ?\GMP $limit;

    private \GMP $consumed;

    private ?\GMP $cost;

    private $payment;

    /**
     * @var Transfer[]
     */
    private ?array $transfers;

    private ?int $sizeEstimate;

    /**
     * @var Transform[]
     */
    private array $effects;

    private ?ExecutionResultV1 $originExecutionResultV1;

    private ?ExecutionResultV2 $originExecutionResultV2;

    public static function fromV1(ExecutionResultV1 $executionResultV1, ?InitiatorAddr $initiatorAddr = null): self
    {
        if ($executionResultV1->getSuccess()) {
            $transforms = [];
            $transfers = [];

            foreach ($executionResultV1->getSuccess()->getEffect()->getTransforms() as $transform) {
                $transforms[] = $transform;

                if (is_array($transform->getKind()) && !array_key_exists('WriteTransfer', $transform->getKind())) {
                    continue;
                }

                $writeTransfer = $transform->getKind();
                if($writeTransfer === null) {
                    continue;
                }

                $transfers[] = $writeTransfer;
            }

            $consumed = $executionResultV1->getSuccess()->getCost();
            return new self(
                $initiatorAddr, null, gmp_init(0), $consumed, gmp_init(0), null, $transfers, null, $transforms, $executionResultV1, null
            );
        }
        else if ($executionResultV1->getFailure()) {
            $transforms = [];
            foreach ($executionResultV1->getFailure()->getEffect()->getTransforms() as $transform) {
                $transforms[] = TransformSerializer::fromJson($transform);
            }

            $errorMessage = $executionResultV1->getFailure()->getErrorMessage();
            $consumed = $executionResultV1->getFailure()->getCost();

            return new self(
                $initiatorAddr, $errorMessage, null, $consumed, null, null, null, null, $transforms, $executionResultV1, null
            );
        }
        else {
            throw new \Exception('Invalid ExecutionResultV1 structure');
        }
    }

    public function __construct(
        ?InitiatorAddr $initiatorAddr,
        ?string $errorMessage,
        ?\GMP $limit,
        \GMP $consumed,
        ?\GMP $cost,
        $payment,
        ?array $transfers,
        ?int $sizeEstimate,
        array $effects,
        ?ExecutionResultV1 $originExecutionResultV1 = null,
        ?ExecutionResultV2 $originExecutionResultV2 = null
    )
    {
        $this->initiatorAddr = $initiatorAddr;
        $this->errorMessage = $errorMessage;
        $this->limit = $limit;
        $this->consumed = $consumed;
        $this->cost = $cost;
        $this->payment = $payment;
        $this->transfers = $transfers;
        $this->sizeEstimate = $sizeEstimate;
        $this->effects = $effects;
        $this->originExecutionResultV1 = $originExecutionResultV1;
        $this->originExecutionResultV2 = $originExecutionResultV2;
    }

    public function getInitiatorAddr(): ?InitiatorAddr
    {
        return $this->initiatorAddr;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    public function getLimit(): ?\GMP
    {
        return $this->limit;
    }

    public function getConsumed(): \GMP
    {
        return $this->consumed;
    }

    public function getCost(): ?\GMP
    {
        return $this->cost;
    }

    public function getPayment()
    {
        return $this->payment;
    }

    public function getTransfers(): ?array
    {
        return $this->transfers;
    }

    public function getSizeEstimate(): ?int
    {
        return $this->sizeEstimate;
    }

    public function getEffects(): array
    {
        return $this->effects;
    }

    public function getOriginExecutionResultV1(): ?ExecutionResultV1
    {
        return $this->originExecutionResultV1;
    }

    public function getOriginExecutionResultV2(): ?ExecutionResultV2
    {
        return $this->originExecutionResultV2;
    }
}
