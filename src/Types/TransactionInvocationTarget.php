<?php

namespace Casper\Types;

class TransactionInvocationTarget
{
    private ?string $byHash;

    private ?string $byName;

    private ?ByPackageHashInvocationTarget $byPackageHash;

    private ?ByPackageNameInvocationTarget $byPackageName;

    public function __construct(
        ?string $byHash,
        ?string $byName,
        ?ByPackageHashInvocationTarget $byPackageHash,
        ?ByPackageNameInvocationTarget $byPackageName
    )
    {
        $this->byHash = $byHash;
        $this->byName = $byName;
        $this->byPackageHash = $byPackageHash;
        $this->byPackageName = $byPackageName;
    }

    public function getByHash(): ?string
    {
        return $this->byHash;
    }

    public function getByName(): ?string
    {
        return $this->byName;
    }

    public function getByPackageHash(): ?ByPackageHashInvocationTarget
    {
        return $this->byPackageHash;
    }

    public function getByPackageName(): ?ByPackageNameInvocationTarget
    {
        return $this->byPackageName;
    }
}
