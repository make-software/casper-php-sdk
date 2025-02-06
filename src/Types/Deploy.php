<?php

namespace Casper\Types;

use Casper\Util\ByteUtil;

class Deploy implements ToBytesConvertible
{
    private array $hash;

    private DeployHeader $header;

    private DeployExecutable $payment;

    private DeployExecutable $session;

    /**
     * @var Approval[]
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

    public function isModuleBytes(): bool
    {
        return $this->payment instanceof DeployExecutableModuleBytes &&
            $this->payment->getHexModuleBytes() !== '';
    }

    public function getSession(): DeployExecutable
    {
        return $this->session;
    }

    public function isTransfer(): bool
    {
        return $this->session instanceof DeployExecutableTransfer;
    }

    public function pushApproval(Approval $approval): self
    {
        $this->approvals[] = $approval;
        return $this;
    }

    /**
     * @return Approval[]
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
                ByteUtil::hexToByteArray($approval->getSigner()->toHex()),
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
