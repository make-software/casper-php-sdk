<?php

namespace Casper\Types;

class TransactionTarget
{
    private ?bool $native;

    private ?StoredTarget $stored;

    private ?SessionTarget $session;

    public static function newTransactionTargetFromSession(DeployExecutable $session): self
    {
        if ($session instanceof DeployExecutableTransfer) {
            return new self(true, null, null);
        }
        else if ($session instanceof DeployExecutableModuleBytes) {
            return new self(null, null, new SessionTarget(
                $session,
                new TransactionRuntime(TransactionRuntime::VM_CASPER_V1_TAG)
            ));
        }
        else if ($session instanceof DeployExecutableStoredVersionedContractByName) {
            return new self(null, new StoredTarget(
                new TransactionInvocationTarget(null, null, null, new ByPackageNameInvocationTarget($session->getName(), $session->getVersion())),
                new TransactionRuntime(TransactionRuntime::VM_CASPER_V1_TAG)
            ), null);
        }
        else if ($session instanceof DeployExecutableStoredVersionedContractByHash) {
            return new self(null, new StoredTarget(
                new TransactionInvocationTarget(null, null, new ByPackageHashInvocationTarget($session->getHash(), $session->getVersion()), null),
                new TransactionRuntime(TransactionRuntime::VM_CASPER_V1_TAG)
            ), null);
        }
        else if ($session instanceof DeployExecutableStoredContractByName) {
            return new self(null, new StoredTarget(
                new TransactionInvocationTarget(null, $session->getName(), null, null),
                new TransactionRuntime(TransactionRuntime::VM_CASPER_V1_TAG)
            ), null);
        }
        else if ($session instanceof DeployExecutableStoredContractByHash) {
            return new self(null, new StoredTarget(
                new TransactionInvocationTarget($session->getHash(), null, null, null),
                new TransactionRuntime(TransactionRuntime::VM_CASPER_V1_TAG)
            ), null);
        }

        return new self(null, null, null);
    }

    public function __construct(?bool $native, ?StoredTarget $stored, ?SessionTarget $session)
    {
        $this->native = $native;
        $this->stored = $stored;
        $this->session = $session;
    }

    public function isNative(): ?bool
    {
        return $this->native;
    }

    public function getStored(): ?StoredTarget
    {
        return $this->stored;
    }

    public function getSession(): ?SessionTarget
    {
        return $this->session;
    }
}
