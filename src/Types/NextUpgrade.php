<?php

namespace Casper\Types;

class NextUpgrade
{
    private int $activationPoint;

    private string $protocolVersion;

    public function __construct(int $activationPoint, string $protocolVersion)
    {
        $this->activationPoint = $activationPoint;
        $this->protocolVersion = $protocolVersion;
    }

    public function getActivationPoint(): int
    {
        return $this->activationPoint;
    }

    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }
}
