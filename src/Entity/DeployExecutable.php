<?php

namespace Casper\Entity;

use Casper\Interfaces\ToBytesInterface;

class DeployExecutable implements ToBytesInterface
{
    private ?DeployExecutableModuleBytes $moduleBytes = null;

    private ?DeployExecutableTransfer $transfer = null;

    public function setModuleBytes(?DeployExecutableModuleBytes $moduleBytes): self
    {
        $this->moduleBytes = $moduleBytes;
        return $this;
    }

    public function setTransfer(?DeployExecutableTransfer $transfer): self
    {
        $this->transfer = $transfer;
        return $this;
    }

    public function isModuleBytes(): bool
    {
        return isset($this->moduleBytes);
    }

    public function isTransfer(): bool
    {
        return isset($this->transfer);
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

        throw new \Exception('Failed to serialize ExecutableDeployItemJsonWrapper');
    }
}
