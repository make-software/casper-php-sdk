<?php

namespace Casper\Types\CLValue;

use Casper\Types\CLValue\CLType\CLType;
use Casper\Types\CLValue\CLType\CLUnitType;

final class CLUnit extends CLValue
{
    public function value()
    {
        return $this->data;
    }

    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        return new CLValueWithRemainder(new self(), $bytes);
    }

    public function clType(): CLUnitType
    {
        return new CLUnitType();
    }

    public function toBytes(): array
    {
        return [];
    }

    public function parsedValue(): string
    {
        return '';
    }
}
