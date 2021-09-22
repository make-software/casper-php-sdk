<?php

namespace Casper\CLType;

final class CLI32 extends Numeric
{
    /**
     * @param string|int|\GMP $value
     * @throws \Exception
     */
    public function __construct($value)
    {
        parent::__construct($value, 32, true);
    }

    public function clType(): CLI32Type
    {
        return new CLI32Type();
    }
}
