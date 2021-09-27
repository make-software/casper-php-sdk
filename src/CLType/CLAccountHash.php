<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

final class CLAccountHash extends CLValue
{
    public const ACCOUNT_HASH_LENGTH = 32;

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
     * @param int[] $bytes
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        if (count($bytes) < self::ACCOUNT_HASH_LENGTH) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
        }

        return new CLValueWithRemainder(
            new self(array_slice($bytes, 0, self::ACCOUNT_HASH_LENGTH)),
            []
        );
    }

    /**
     * @param int[] $byteArray
     * @throws \Exception
     */
    private function assertByteArrayIsValid(array $byteArray): void
    {
        if (!ByteUtil::isByteArray($byteArray)) {
            throw new \Exception('Incorrect byte array: ' . join(',', $byteArray));
        }
    }

    public function value(): array
    {
        return $this->data;
    }

    public function clType(): CLAccountHashType
    {
        return new CLAccountHashType();
    }

    public function toBytes(): array
    {
        return $this->data;
    }
}
