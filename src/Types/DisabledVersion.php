<?php

namespace Casper\Types;

class DisabledVersion
{
    private int $accessKey;

    private int $contractVersion;

    public function __construct(int $accessKey, int $contractVersion)
    {
        $this->accessKey = $accessKey;
        $this->contractVersion = $contractVersion;
    }

    public function getAccessKey(): int
    {
        return $this->accessKey;
    }

    public function getContractVersion(): int
    {
        return $this->contractVersion;
    }
}
