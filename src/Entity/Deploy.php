<?php

namespace Casper\Entity;

use Casper\Util\ByteUtil;
use Casper\Util\HashUtil;

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

    public function isStandardPayment(): bool
    {
        if ($this->payment->isModuleBytes()) {
            $moduleBytesEntity = $this->payment->getModuleBytes();

            if ($moduleBytesEntity && count($moduleBytesEntity->getModuleBytes()) !== 0) {
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
            array_merge($this->payment->toBytes(), $this->session->toBytes()),
            $approvalsBytes
        );
    }

    public function validate(): bool
    {
        $bodyHash = HashUtil::blake2bHash(
            array_merge($this->payment->toBytes(), $this->session->toBytes())
        );

        if ($this->header->getBodyHash() !== $bodyHash) {
            return false;
        }

        $deployHash = HashUtil::blake2bHash($this->header->toBytes());

        if ($this->hash !== $deployHash) {
            return false;
        }

        return true;
    }
}
