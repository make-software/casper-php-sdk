<?php

namespace Casper\Types;

class Transform
{
    private string $key;

    /** @var string|array  */
    private $kind;

    public function __construct(string $key, $kind)
    {
        $this->key = $key;
        $this->kind = $kind;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getKind()
    {
        return $this->kind;
    }
}
