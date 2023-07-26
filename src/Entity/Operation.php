<?php

namespace Casper\Entity;

class Operation
{
    private string $key;

    private string $kind;

    public function __construct(string $key, string $kind)
    {
        $this->key = $key;
        $this->kind = $kind;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getKind(): string
    {
        return $this->kind;
    }
}
