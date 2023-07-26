<?php

namespace Casper\Entity;

class Transform
{
    private string $key;

    /** @var string|array  */
    private $transform;

    public function __construct(string $key, $transform)
    {
        $this->key = $key;
        $this->transform = $transform;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getTransform()
    {
        return $this->transform;
    }
}
