<?php

namespace Casper\Types\CLValue;

use Casper\Types\CLValue\CLType\CLType;
use Casper\Types\CLValue\CLType\CLU32Type;
use Casper\Util\ByteUtil;

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

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        if (count($bytes) < 4) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
        }

        return new CLValueWithRemainder(
            new self(gmp_import(ByteUtil::byteArrayToString(array_reverse(array_slice($bytes, 0, 4))))),
            array_slice($bytes, 4)
        );
    }

    public function clType(): CLU32Type
    {
        return new CLU32Type();
    }
}
