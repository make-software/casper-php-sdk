<?php

namespace Casper\Types;

class DeployHash implements ToBytesConvertible
{
    /**
     * @var int[]
     */
    private array $hash;

    /**
     * @param int[] $hash
     */
    public function __construct(array $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return int[]
     */
    public function toBytes(): array
    {
        return $this->hash;
    }
}
