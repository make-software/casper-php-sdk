<?php

namespace Casper\CLType;

final class CLI64 extends Numeric
{
    /**
     * @param string|int|\GMP $value
     * @throws \Exception
     */
    public function __construct($value)
    {
        parent::__construct($value, 64, true);
    }

    public function clType(): CLI64Type
    {
        return new CLI64Type();
    }
}
