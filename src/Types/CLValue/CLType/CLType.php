<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLTypeTag;

abstract class CLType
{
    protected CLTypeTag $tag;

    protected string $linkTo;

    public function getTag(): CLTypeTag
    {
        return $this->tag;
    }

    public function getLinkTo(): string
    {
        return $this->linkTo;
    }

    public function toString(): string
    {
        return $this->tag->getTagName();
    }

    /**
     * @return string|array
     */
    public function toJson()
    {
        return $this->toString();
    }

    /**
     * @return int[]
     */
    public function toBytes(): array
    {
        return [$this->tag->getTagValue()];
    }
}
