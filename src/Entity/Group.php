<?php

namespace Casper\Entity;

class Group
{
    private string $group;

    private string $keys;

    public function __construct(string $group, string $keys)
    {
        $this->group = $group;
        $this->keys = $keys;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function getKeys(): string
    {
        return $this->keys;
    }
}
