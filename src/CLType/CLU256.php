<?php

namespace Casper\CLType;

final class CLU256 extends Numeric
{
    /**
     * @param string|int|\GMP $value
     * @throws \Exception
     */
    public function __construct($value)
    {
        parent::__construct($value, 256, false);
    }

    public function clType(): CLU256Type
    {
        return new CLU256Type();
    }
}
