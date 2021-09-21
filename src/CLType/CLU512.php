<?php

namespace Casper\CLType;

final class CLU512 extends Numeric
{
    /**
     * @param string|int|\GMP $value
     * @throws \Exception
     */
    public function __construct($value)
    {
        parent::__construct($value, 512, false);
    }

    public function clType(): CLU512Type
    {
        return new CLU512Type();
    }
}
