<?php

namespace Casper\Entity;

use Casper\CLType\CLType;

class NamedCLTypeArg
{
    private string $name;

    private CLType $clType;

    public function __construct(string $name, CLType $clType)
    {
        $this->name = $name;
        $this->clType = $clType;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getClType(): CLType
    {
        return $this->clType;
    }
}
