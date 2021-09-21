<?php

namespace Casper\Model;

use Casper\Entity\DeployExecutableTransfer;
use Casper\Interfaces\ToBytesInterface;

class DeployExecutable implements ToBytesInterface
{
    private ?DeployExecutableModuleBytes $moduleBytes = null;

    private ?DeployExecutableTransfer $transfer = null;

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

    public function isModuleBytes(): bool
    {
        return isset($this->moduleBytes);
    }

    public function isTransfer(): bool
    {
        return isset($this->transfer);
    }
}
