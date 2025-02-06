<?php

namespace Casper\Types;

class ByPackageHashInvocationTarget
{
    private string $addr;

    private ?int $version;

    public function __construct(string $addr, ?int $version)
    {
        $this->addr = $addr;
        $this->version = $version;
    }

    public function getAddr(): string
    {
        return $this->addr;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }
}
