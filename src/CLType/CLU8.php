<?php

namespace Casper\CLType;

final class CLU8 extends Numeric
{
    /**
     * @param string|int|\GMP $value
     * @throws \Exception
     */
    public function __construct($value)
    {
        parent::__construct($value, 8, false);
    }

    public function clType(): CLU8Type
    {
        return new CLU8Type();
    }
}
