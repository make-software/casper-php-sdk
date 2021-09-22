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
}
