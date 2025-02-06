<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLList;
use Casper\Types\CLValue\CLTypeTag;

final class CLListType extends CLType
{
    private CLType $inner;

    public function __construct(CLType $inner)
    {
        $this->tag = new CLTypeTag(CLTypeTag::LIST);
        $this->linkTo = CLList::class;
        $this->inner = $inner;
    }

    public function getInner(): CLType
    {
        return $this->inner;
    }

    public function toString(): string
    {
        return parent::toString() . ' (' . $this->inner->toString() . ')';
    }

    public function toJson(): array
    {
        return [
            parent::toString() => $this->inner->toJson()
        ];
    }

    public function toBytes(): array
    {
        return array_merge(parent::toBytes(), $this->inner->toBytes());
    }
}
