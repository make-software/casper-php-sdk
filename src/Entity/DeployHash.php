<?php

namespace Casper\Entity;

use Casper\Interfaces\ToBytesInterface;

class DeployHash implements ToBytesInterface
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
