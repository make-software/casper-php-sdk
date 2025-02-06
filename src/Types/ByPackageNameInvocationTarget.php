<?php

namespace Casper\Types;

class ByPackageNameInvocationTarget
{
    private string $name;

    private ?int $version;

    public function __construct(string $name, ?int $version)
    {
        $this->name = $name;
        $this->version = $version;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }
}
