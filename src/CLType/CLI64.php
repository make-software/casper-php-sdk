<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

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

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        if (count($bytes) < 8) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
        }

        return new CLValueWithRemainder(
            new self(
                gmp_import(
                    ByteUtil::byteArrayToString(array_reverse(array_slice($bytes, 0, 8)))
                )
            ),
            array_slice($bytes, 8)
        );
    }

    public function clType(): CLI64Type
    {
        return new CLI64Type();
    }
}
