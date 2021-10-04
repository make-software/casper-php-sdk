<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

final class CLString extends CLValue
{
    public function __construct(string $value)
    {
        $this->data = $value;
    }

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        $u32Result = CLU32::fromBytesWithRemainder($bytes);
        $length = (int) $u32Result->getClValue()->value();

        if ($u32Result->getRemainder()) {
            return new CLValueWithRemainder(
                new self(ByteUtil::byteArrayToString(array_slice($u32Result->getRemainder(), 0, $length))),
                array_slice($u32Result->getRemainder(), $length)
            );
        }

        self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
    }

    public function value(): string
    {
        return $this->data;
    }

    public function clType(): CLStringType
    {
        return new CLStringType();
    }

    /**
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return ByteUtil::stringToBytesU32($this->data);
    }

    public function toString(): string
    {
        return $this->data;
    }
}
