<?php

namespace Casper\Entity;

use Casper\Util\ByteUtil;
use Casper\Util\HashUtil;

class Deploy implements ToBytesConvertible
{
    private array $hash; // Hash

    private DeployHeader $header;

    private DeployExecutable $payment;

    private DeployExecutable $session;

    /**
     * @var DeployApproval[]
     */
    private array $approvals;

    public function __construct(
        array $hash,
        DeployHeader $header,
        DeployExecutable $payment,
        DeployExecutable $session,
        array $approvals = []
    )
    {
        $this->hash = $hash;
        $this->header = $header;
        $this->payment = $payment;
        $this->session = $session;
        $this->approvals = $approvals;
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

    public function isStandardPayment(): bool
    {
        if ($this->payment->isModuleBytes()) {
            $moduleBytesEntity = $this->payment->getModuleBytes();

            if ($moduleBytesEntity && $moduleBytesEntity->getModuleBytes() !== '') {
                return true;
            }
        }

        return false;
    }

    public function getSession(): DeployExecutable
    {
        return $this->session;
    }

    public function isTransfer(): bool
    {
        return $this->session->isTransfer();
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
    public function toBytes(): array
    {
        $approvalsBytes = ByteUtil::toBytesU32(count($this->approvals));

        foreach ($this->approvals as $approval) {
            $signerAndSignatureBytes = array_merge(
                ByteUtil::hexToByteArray($approval->getSigner()),
                ByteUtil::hexToByteArray($approval->getSignature())
            );

            $approvalsBytes = array_merge($approvalsBytes, $signerAndSignatureBytes);
        }

        return array_merge(
            $this->header->toBytes(),
            $this->hash,
            $this->payment->toBytes(),
            $this->session->toBytes(),
            $approvalsBytes
        );
    }
}
