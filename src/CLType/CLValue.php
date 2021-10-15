<?php

namespace Casper\CLType;

use Casper\Entity\ToBytesConvertible;
use Casper\Util\ByteUtil;

abstract class CLValue implements ToBytesConvertible
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @return mixed
     */
    abstract public function value();

    abstract public function parsedValue();

    abstract public function clType(): CLType;

    abstract public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder;

    /**
     * @param int[] $bytes
     * @throws \Exception
     */
    public static function fromBytes(array $bytes, ?CLType $innerType = null): CLValue
    {
        $clValueWithRemainder = static::fromBytesWithRemainder($bytes, $innerType);

        if (count($clValueWithRemainder->getRemainder())) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_LEFT_OVER_BYTES);
        }

        return $clValueWithRemainder->getClValue();
    }

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytesWithType(): array
    {
        return array_merge(
            ByteUtil::toBytesArrayU8($this->toBytes()),
            $this->clType()->toBytes()
        );
    }

    /**
     * @param int|string $errorCode
     * @throws \Exception
     */
    protected static function throwFromBytesCreationError($errorCode): void
    {
        throw new \Exception("From bytes creation error. Error code: $errorCode");
    }
}
