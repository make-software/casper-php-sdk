<?php

namespace Casper\Entity;

use Casper\CLType\CLByteArray;
use Casper\CLType\CLOption;
use Casper\CLType\CLPublicKey;
use Casper\CLType\CLU512;
use Casper\CLType\CLU64;
use Casper\CLType\CLURef;

use Casper\Interfaces\ToBytesInterface;

class DeployExecutable implements ToBytesInterface
{
    private ?DeployExecutableModuleBytes $moduleBytes = null;

    private ?DeployExecutableTransfer $transfer = null;

    protected ?DeployExecutableStoredContractByHash $storedContractByHash = null;

    /**
     * @param string|int|\GMP $amount
     * @return DeployExecutable
     * @throws \Exception
     */
    public static function newStandardPayment($amount): DeployExecutable
    {
        $moduleBytes = (new DeployExecutableModuleBytes(''))
            ->setArg(new DeployNamedArg('amount', new CLU512($amount)));

        return (new self())
            ->setModuleBytes($moduleBytes);
    }

    /**
     * @param string|int|\GMP $id
     * @param string|int|\GMP $amount
     * @param CLURef|CLPublicKey $target
     * @param CLURef|null $sourcePurse
     * @return DeployExecutable
     * @throws \Exception
     */
    public static function newTransfer($id, $amount, $target, CLURef $sourcePurse = null): DeployExecutable
    {
        if ($target instanceof CLURef) {
            $targetValue = $target;
        }
        elseif ($target instanceof CLPublicKey) {
            $targetValue = new CLByteArray($target->toAccountHash());
        }
        else {
            throw new \Exception('Please specify target');
        }

        $transfer = (new DeployExecutableTransfer())
            ->setArg(new DeployNamedArg('amount', new CLU512($amount)));

        if ($sourcePurse !== null) {
            $transfer->setArg(new DeployNamedArg('source', $sourcePurse));
        }

        $transfer
            ->setArg(new DeployNamedArg('target', $targetValue))
            ->setArg(new DeployNamedArg('id', new CLOption(new CLU64($id))));

        return (new self())
            ->setTransfer($transfer);
    }

    public function setModuleBytes(?DeployExecutableModuleBytes $moduleBytes): self
    {
        $this->moduleBytes = $moduleBytes;
        return $this;
    }

    public function getModuleBytes(): ?DeployExecutableModuleBytes
    {
        return $this->moduleBytes;
    }

    public function isModuleBytes(): bool
    {
        return isset($this->moduleBytes);
    }

    public function setTransfer(?DeployExecutableTransfer $transfer): self
    {
        $this->transfer = $transfer;
        return $this;
    }

    public function getTransfer(): ?DeployExecutableTransfer
    {
        return $this->transfer;
    }

    public function isTransfer(): bool
    {
        return isset($this->transfer);
    }

    public function setStoredContractByHash(?DeployExecutableStoredContractByHash $storedContractByHash): self
    {
        $this->storedContractByHash = $storedContractByHash;
        return $this;
    }

    public function getStoredContractByHash(): ?DeployExecutableStoredContractByHash
    {
        return $this->storedContractByHash;
    }

    public function isStoredContractByHash(): bool
    {
        return isset($this->storedContractByHash);
    }

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytes(): array
    {
        if ($this->isModuleBytes()) {
            return $this->moduleBytes->toBytes();
        }
        elseif ($this->isTransfer()) {
            return $this->transfer->toBytes();
        }
        elseif ($this->isStoredContractByHash()) {
            return $this->storedContractByHash->toBytes();
        }

        throw new \Exception('Failed to serialize ExecutableDeployItemJsonWrapper');
    }
}
