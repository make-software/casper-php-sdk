<?php

namespace Casper\CLType;

final class CLListType extends CLType
{
    private CLType $inner;

    public function __construct(CLType $inner)
    {
        $this->tag = new CLTypeTag(CLTypeTag::LIST);
        $this->linkTo = CLList::class;
        $this->inner = $inner;
    }

    public function toString(): string
    {
        return parent::toString() . ' (' . $this->inner->toString() . ')';
    }

    public function toJSON(): array
    {
        return [
            parent::toString() => $this->inner->toJSON()
        ];
    }

    public function toBytes(): array
    {
        return array_merge(parent::toBytes(), $this->inner->toBytes());
    }
}
