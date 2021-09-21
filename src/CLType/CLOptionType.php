<?php

namespace Casper\CLType;

final class CLOptionType extends CLType
{
    private const NAME = 'Option';

    private ?CLType $innerType;

    public function __construct(?CLType $innerType)
    {
        $this->tag = new CLTypeTag(CLTypeTag::OPTION);
        $this->linkTo = CLOption::class;
        $this->innerType = $innerType;
    }

    public function toString(): string
    {
        return $this->innerType === null
            ? self::NAME . ' (None)'
            : self::NAME . ' (' . $this->innerType->toString() . ')';
    }

    public function toJSON(): array
    {
        return array(
            self::NAME => ($this->innerType === null ? 'None' : $this->innerType->toJSON())
        );
    }

    /**
     * @return int[]
     */
    public function toBytes(): array
    {
        return array_merge([
            $this->tag->getTagValue()],
            ($this->innerType === null ? [] : $this->innerType->toBytes())
        );
    }
}
