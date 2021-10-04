<?php

namespace Casper\CLType;

class CLMapType extends CLType
{
    private CLType $innerKey;

    private CLType $innerValue;

    public function __construct(array $data)
    {
        $this->tag = new CLTypeTag(CLTypeTag::MAP);
        $this->linkTo = CLMap::class;

        $this->innerKey = $data[0];
        $this->innerValue = $data[1];
    }

    public function getInnerKey(): CLType
    {
        return $this->innerKey;
    }

    public function getInnerValue(): CLType
    {
        return $this->innerValue;
    }

    public function toString(): string
    {
        return parent::toString() . ' (' . $this->innerKey->toString() . ': ' . $this->innerValue->toString() . ')';
    }

    public function toJson(): array
    {
        return array(
            $this->tag->getTagName() => array(
                'key' => $this->innerKey->toJson(),
                'value' => $this->innerValue->toJson()
            )
        );
    }

    public function toBytes(): array
    {
        return array_merge(
            parent::toBytes(),
            $this->innerKey->toBytes(),
            $this->innerValue->toBytes()
        );
    }
}
