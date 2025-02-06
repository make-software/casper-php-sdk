<?php

namespace Casper\Types\CLValue;

use Casper\Types\CLValue\CLType\CLAccountHashType;
use Casper\Types\CLValue\CLType\CLType;
use Casper\Util\ByteUtil;

final class CLAccountHash extends CLValue
{
    public const ACCOUNT_HASH_PREFIX = 'account-hash-';
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

    public static function fromHex(string $accountHex): self
    {
        return self::fromString(self::ACCOUNT_HASH_PREFIX . $accountHex);
    }

    /**
     * @throws \Exception
     */
    public static function fromString(string $accountHashString): self
    {
        $prefix = substr($accountHashString, 0, 13);

        if ($prefix !== CLAccountHash::ACCOUNT_HASH_PREFIX) {
            throw new \Exception('Account hash string starts with "account-hash-" prefix');
        }

        return new CLAccountHash(
            ByteUtil::hexToByteArray(str_replace(CLAccountHash::ACCOUNT_HASH_PREFIX, '', $accountHashString))
        );
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

    public function value(): array
    {
        return $this->data;
    }

    public function parsedValue(): string
    {
        return 'account-hash-' . ByteUtil::byteArrayToHex($this->data);
    }

    public function clType(): CLAccountHashType
    {
        return new CLAccountHashType();
    }

    public function toBytes(): array
    {
        return $this->data;
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
        else if (count($byteArray) !== self::ACCOUNT_HASH_LENGTH) {
            $message = 'Incorrect byte array length';
        }

        if (isset($message)) {
            throw new \Exception($message);
        }
    }
}
