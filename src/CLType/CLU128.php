<?php

namespace Casper\CLType;

final class CLU128 extends Numeric
{
    /**
     * @param string|int|\GMP $value
     * @throws \Exception
     */
    public function __construct($value)
    {
        parent::__construct($value, 128, false);
    }

    public function clType(): CLU128Type
    {
        return new CLU128Type();
    }

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        return self::fromBytesBigInt($bytes, 128);
    }
}
