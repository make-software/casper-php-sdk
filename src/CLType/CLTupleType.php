<?php

namespace Casper\CLType;

abstract class CLTupleType extends CLType
{
    /**
     * @var CLType[]
     */
    protected array $inner;

    /**
     * @param CLType[] $inner
     * @param CLTypeTag $tag
     * @param string $linksTo
     *
     * @throws \Exception
     */
    public function __construct(array $inner, CLTypeTag $tag, string $linksTo)
    {
        foreach ($inner as $item) {
            if (!$item instanceof CLType) {
                throw new \Exception('Invalid data type(s) provided.');
            }
        }

        $this->inner = $inner;
        $this->tag = $tag;
        $this->linkTo = $linksTo;
    }

    /**
     * @return CLType[]
     */
    public function getInner(): array
    {
        return $this->inner;
    }

    public function toString(): string
    {
        return parent::toString() . ' (' . join(', ', array_map(
            function ($item) {
                return $item->toString();
            }, $this->inner)
        ) . ')';
    }

    public function toJSON(): array
    {
        return [
            parent::toString() => array_map(function ($item) {
                return $item->toJSON();
            }, $this->inner)
        ];
    }

    public function toBytes(): array
    {
        $result = [];

        foreach ($this->inner as $item) {
            $result = array_merge($result, $item->toBytes());
        }

        return array_merge(parent::toBytes(), $result);
    }
}
