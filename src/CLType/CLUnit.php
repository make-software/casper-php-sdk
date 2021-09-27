<?php

namespace Casper\CLType;

final class CLUnit extends CLValue
{
    public function value()
    {
        return $this->data;
    }

    public function clType(): CLUnitType
    {
        return new CLUnitType();
    }

    public function toBytes(): array
    {
        return [];
    }

    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        return new CLValueWithRemainder(new self(), $bytes);
    }
}
