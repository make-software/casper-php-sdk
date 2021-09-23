<?php

namespace Casper\Entity;

class Deploy
{
    /**
     * @var int[]
     */
    private array $hash;

    private DeployHeader $header;

    private DeployExecutable $payment;

    private DeployExecutable $session;

    /**
     * @var DeployApproval[]
     */
    private array $approvals = [];

    /**
     * @param int[] $hash
     * @param DeployHeader $header
     * @param DeployExecutable $payment
     * @param DeployExecutable $session
     */
    public function __construct(
        array $hash,
        DeployHeader $header,
        DeployExecutable $payment,
        DeployExecutable $session
    )
    {
        $this->hash = $hash;
        $this->header = $header;
        $this->payment = $payment;
        $this->session = $session;
    }

    public function getHash(): array
    {
        return $this->hash;
    }

    public function getHeader(): DeployHeader
    {
        return $this->header;
    }

    public function getPayment(): DeployExecutable
    {
        return $this->payment;
    }

    public function getSession(): DeployExecutable
    {
        return $this->session;
    }

    public function pushApproval(DeployApproval $approval): self
    {
        $this->approvals[] = $approval;
        return $this;
    }

    /**
     * @return DeployApproval[]
     */
    public function getApprovals(): array
    {
        return $this->approvals;
    }

    /**
     * @throws \Exception
     */
    public function size(): int
    {
        $hashSize = count($this->hash);
        $bodySize = count(array_merge($this->payment->toBytes(), $this->session->toBytes()));
        $headerSize = count($this->header->toBytes());
        $approvalsSize = 0;

        foreach ($this->approvals as $approval) {
            $approvalsSize += (strlen($approval->getSigner()) + strlen($approval->getSignature())) / 2;
        }

        return $hashSize + $bodySize + $headerSize + $approvalsSize;
    }
}
