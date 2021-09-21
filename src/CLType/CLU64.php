<?php

namespace Casper\CLType;

final class CLU64 extends Numeric
{
    /**
     * @param string|int|\GMP $value
     * @throws \Exception
     */
    public function __construct($value)
    {
        parent::__construct($value, 64, false);
    }

    public function clType(): CLU64Type
    {
        return new CLU64Type();
    }
}
