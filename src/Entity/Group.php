<?php

namespace Casper\Entity;

use Casper\CLType\CLURef;

class Group
{
    private string $group;

    /**
     * @var CLURef[]
     */
    private array $keys;

    public function __construct(string $group, array $keys)
    {
        $this->group = $group;
        $this->keys = $keys;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function getKeys(): array
    {
        return $this->keys;
    }
}
