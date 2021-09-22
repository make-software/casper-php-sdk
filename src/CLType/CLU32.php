<?php

namespace Casper\CLType;

final class CLU32 extends Numeric
{
    /**
     * @param string|int|\GMP $value
     * @throws \Exception
     */
    public function __construct($value)
    {
        parent::__construct($value, 32, false);
    }

    public function clType(): CLU32Type
    {
        return new CLU32Type();
    }
}
