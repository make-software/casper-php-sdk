<?php

namespace Casper\Entity;

use Casper\CLType\CLOption;
use Casper\CLType\CLPublicKey;
use Casper\CLType\CLU512;
use Casper\CLType\CLU64;
use Casper\CLType\CLURef;

class DeployExecutable implements ToBytesConvertible
{
    private ?DeployExecutableModuleBytes $moduleBytes = null;

    private ?DeployExecutableTransfer $transfer = null;

    private ?DeployExecutableStoredContractByHash $storedContractByHash = null;

    private ?DeployExecutableStoredContractByName $storedContractByName = null;

    private ?DeployExecutableStoredVersionedContractByHash $storedVersionedContractByHash = null;

    private ?DeployExecutableStoredVersionedContractByName $storedVersionedContractByName = null;

    /**
     * @param string|int|\GMP $amount
     * @return DeployExecutable
     * @throws \Exception
     */
    public static function newStandardPayment($amount): self
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
    public static function newTransfer($id, $amount, $target, CLURef $sourcePurse = null): self
    {
        if (!in_array(get_class($target), [CLURef::class, CLPublicKey::class])) {
            throw new \Exception('Please specify target');
        }

        $transfer = (new DeployExecutableTransfer())
            ->setArg(new DeployNamedArg('amount', new CLU512($amount)));

        if ($sourcePurse !== null) {
            $transfer->setArg(new DeployNamedArg('source', $sourcePurse));
        }

        $transfer
            ->setArg(new DeployNamedArg('target', $target))
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

    public function setStoredContractByName(?DeployExecutableStoredContractByName $storedContractByName): self
    {
        $this->storedContractByName = $storedContractByName;
        return $this;
    }

    public function getStoredContractByName(): ?DeployExecutableStoredContractByName
    {
        return $this->storedContractByName;
    }

    public function isStoredContractByName(): bool
    {
        return isset($this->storedContractByName);
    }

    public function setStoredVersionedContractByHash(
        ?DeployExecutableStoredVersionedContractByHash $storedVersionedContractByHash
    ): self
    {
        $this->storedVersionedContractByHash = $storedVersionedContractByHash;
        return $this;
    }

    public function getStoredVersionedContractByHash(): ?DeployExecutableStoredVersionedContractByHash
    {
        return $this->storedVersionedContractByHash;
    }

    public function isStoredVersionedContractByHash(): bool
    {
        return isset($this->storedVersionedContractByHash);
    }

    public function setStoredVersionedContractByName(?DeployExecutableStoredVersionedContractByName $storedVersionedContractByName): self
    {
        $this->storedVersionedContractByName = $storedVersionedContractByName;
        return $this;
    }

    public function getStoredVersionedContractByName(): ?DeployExecutableStoredVersionedContractByName
    {
        return $this->storedVersionedContractByName;
    }

    public function isStoredVersionedContractByName(): bool
    {
        return isset($this->storedVersionedContractByName);
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
        elseif ($this->isStoredContractByName()) {
            return $this->storedContractByName->toBytes();
        }
        elseif ($this->isStoredVersionedContractByHash()) {
            return $this->storedVersionedContractByHash->toBytes();
        }
        elseif ($this->isStoredVersionedContractByName()) {
            return $this->storedVersionedContractByHash->toBytes();
        }

        throw new \Exception('Failed to serialize ExecutableDeployItemJsonWrapper');
    }
}
