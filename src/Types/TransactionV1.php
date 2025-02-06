<?php

namespace Casper\Types;

class TransactionV1
{
    private string $hash;

    private TransactionV1Payload $payload;

    /**
     * @var Approval[]
     */
    private array $approvals;

    public function __construct(string $hash, TransactionV1Payload $payload, array $approvals = [])
    {
        $this->hash = $hash;
        $this->payload = $payload;
        $this->approvals = $approvals;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getPayload(): TransactionV1Payload
    {
        return $this->payload;
    }

    public function getApprovals(): array
    {
        return $this->approvals;
    }
}
