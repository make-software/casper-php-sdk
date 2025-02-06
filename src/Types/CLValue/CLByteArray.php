<?php

namespace Casper\Types\CLValue;

use Casper\Types\CLValue\CLType\CLByteArrayType;
use Casper\Types\CLValue\CLType\CLType;
use Casper\Util\ByteUtil;

final class CLByteArray extends CLValue
{
    private const CL_BYTE_ARRAY_MAX_LENGTH = 32;

    /**
     * @param int[] $byteArray
     * @throws \Exception
     */
    public function __construct(array $byteArray)
    {
        $this->assertByteArrayIsValid($byteArray);
        $this->data = $byteArray;
    }

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        return new CLValueWithRemainder(
            new self(array_slice($bytes, 0, self::CL_BYTE_ARRAY_MAX_LENGTH)),
            array_slice($bytes, self::CL_BYTE_ARRAY_MAX_LENGTH)
        );
    }

    /**
     * @return int[]
     */
    public function value(): array
    {
        return $this->data;
    }

    public function clType(): CLByteArrayType
    {
        return new CLByteArrayType(count($this->data));
    }

    /**
     * @return int[]
     */
    public function toBytes(): array
    {
        return $this->data;
    }

    public function parsedValue(): string
    {
        return ByteUtil::byteArrayToHex($this->data);
    }

    /**
     * @param int[] $byteArray
     * @throws \Exception
     */
    private function assertByteArrayIsValid(array $byteArray): void
    {
        if (!ByteUtil::isByteArray($byteArray)) {
            $message = 'Incorrect byte array: ' . join(',', $byteArray);
        }
        else if ($length = count($byteArray) > self::CL_BYTE_ARRAY_MAX_LENGTH) {
            $message = 'Provided value has length ' . $length . ' which exceeded the limit ' . self::CL_BYTE_ARRAY_MAX_LENGTH;
        }

        if (isset($message)) {
            throw new \Exception($message);
        }
    }
}
