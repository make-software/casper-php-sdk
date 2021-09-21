<?php

namespace Casper\CLType;

use Casper\Interfaces\ToBytesInterface;

abstract class CLType implements ToBytesInterface
{
    protected CLTypeTag $tag;

    protected string $linkTo;

    abstract public function toString(): string;

    abstract public function toJSON(): string;

    public function toBytes(): array
    {
        return [$this->tag->getTagValue()];
    }
}
