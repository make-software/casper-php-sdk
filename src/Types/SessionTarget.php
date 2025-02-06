<?php

namespace Casper\Types;

class SessionTarget
{
    private DeployExecutableModuleBytes $moduleBytes;

    private TransactionRuntime $runtime;

    private ?bool $isInstallUpgrade;

    public function __construct(
        DeployExecutableModuleBytes $moduleBytes,
        TransactionRuntime $runtime,
        bool $isInstallUpgrade = null
    )
    {
        $this->moduleBytes = $moduleBytes;
        $this->runtime = $runtime;
        $this->isInstallUpgrade = $isInstallUpgrade;
    }

    public function getModuleBytes(): DeployExecutableModuleBytes
    {
        return $this->moduleBytes;
    }

    public function getRuntime(): TransactionRuntime
    {
        return $this->runtime;
    }

    public function isInstallUpgrade(): ?bool
    {
        return $this->isInstallUpgrade;
    }
}
