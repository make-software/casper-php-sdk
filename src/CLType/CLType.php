<?php

namespace Casper\CLType;

use Casper\Interfaces\ToBytesInterface;

abstract class CLType implements ToBytesInterface
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
