<?php

namespace Casper\Types\CLValue;

use Casper\Types\CLValue\CLType\CLType;
use Casper\Types\CLValue\CLType\CLU8Type;

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

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        if (count($bytes) < 1) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
        }

        return new CLValueWithRemainder(
            new self($bytes[0]),
            array_slice($bytes, 1)
        );
    }

    public function clType(): CLU8Type
    {
        return new CLU8Type();
    }
}
