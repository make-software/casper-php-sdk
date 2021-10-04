<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

abstract class Numeric extends CLValue
{
    /**
     * @var \GMP
     */
    protected $data;

    protected int $bitSize;

    protected bool $signed;

    /**
     * @param int|string|\GMP $value
     * @param int $bitSize
     * @param bool $isSigned
     *
     * @throws \Exception
     */
    public function __construct($value, int $bitSize, bool $isSigned)
    {
        $this->bitSize = $bitSize;
        $this->signed = $isSigned;
        $this->data = gettype($value) === 'object' && get_class($value) === 'GMP'
            ? $value
            : gmp_init($value);

        if ($isSigned === false && gmp_cmp($this->data, 0) === -1) {
            throw new \Exception('Can\'t provide negative numbers with isSigned=false');
        }
    }

    public function value(): \GMP
    {
        return $this->data;
    }

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return ByteUtil::toBytesNumber($this->bitSize, $this->signed, $this->data);
    }

    public function toString(): string
    {
        return (string) $this->data;
    }

    /**
     * @param int[] $bytes
     * @param int $bitSize
     * @return Numeric
     * @throws \Exception
     */
    protected static function fromBytesBigInt(array $bytes, int $bitSize): CLValueWithRemainder
    {
        if (count($bytes) < 1) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
        }

        $byteSize = $bitSize / 8;
        $n = $bytes[0];

        if ($n > $byteSize) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_FORMATTING);
        }

        if (($n + 1) > count($bytes)) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
        }

        $bigIntBytes = $n === 0 ? [0] : array_slice($bytes, 1, $n);

        return new CLValueWithRemainder(
            new static(gmp_import(ByteUtil::byteArrayToString(array_reverse($bigIntBytes)))),
            array_slice($bytes, $n + 1)
        );
    }
}
