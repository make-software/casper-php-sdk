<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLOption;
use Casper\Types\CLValue\CLTypeTag;

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

    public function toJson(): array
    {
        return array(
            self::NAME => ($this->innerType === null ? 'None' : $this->innerType->toJson())
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
