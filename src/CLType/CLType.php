<?php

namespace Casper\CLType;

abstract class CLType
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
