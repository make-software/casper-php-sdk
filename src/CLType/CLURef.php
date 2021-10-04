<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

final class CLURef extends CLValue
{
    private const UREF_ACCESS_RIGHTS_LENGTH = 1;
    private const UREF_ADDRESS_LENGTH = 32;

    // No permissions
    public const ACCESS_NONE = 0b0;

    // Permission to read the value under the associated [[URef]].
    public const ACCESS_READ = 0b001;

    // Permission to write a value under the associated [[URef]].
    public const ACCESS_WRITE = 0b010;

    // Permission to add to the value under the associated [[URef]].
    public const ACCESS_ADD = 0b100;

    // Permission to read or write the value under the associated [[URef]].
    public const ACCESS_READ_WRITE = self::ACCESS_READ | self::ACCESS_WRITE;

    // Permission to read or add to the value under the associated [[URef]].
    public const ACCESS_READ_ADD = self::ACCESS_READ | self::ACCESS_ADD;

    // Permission to add to, or write the value under the associated [[URef]].
    public const ACCESS_ADD_WRITE = self::ACCESS_ADD | self::ACCESS_WRITE;

    // Permission to read, add to, or write the value under the associated [[URef]].
    public const ACCESS_READ_ADD_WRITE = self::ACCESS_READ | self::ACCESS_ADD | self::ACCESS_WRITE;

    private const ACCESS_RIGHTS = [
        self::ACCESS_NONE,
        self::ACCESS_READ,
        self::ACCESS_WRITE,
        self::ACCESS_ADD,
        self::ACCESS_READ_WRITE,
        self::ACCESS_READ_ADD,
        self::ACCESS_ADD_WRITE,
        self::ACCESS_READ_ADD_WRITE,
    ];

    private int $accessRights;

    /**
     * @param int[] $urefAddress Bytes representing address of the URef.
     * @param int $accessRights Access rights flag. Use self::ACCESS_NONE to indicate no permissions.
     *
     * @throws \Exception
     */
    public function __construct(array $urefAddress, int $accessRights)
    {
        $this->assertURefAddressIsValid($urefAddress);
        $this->assertAccessRightsIsValid($accessRights);

        $this->data = $urefAddress;
        $this->accessRights = $accessRights;
    }

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        $bytesLength = self::UREF_ADDRESS_LENGTH + self::UREF_ACCESS_RIGHTS_LENGTH;

        if (count($bytes) < $bytesLength) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
        }

        $urefBytes = array_slice($bytes, 0, self::UREF_ADDRESS_LENGTH);
        $accessRightsByte = $bytes[$bytesLength - 1];

        return new CLValueWithRemainder(
            new self($urefBytes, $accessRightsByte),
            array_slice($bytes, $bytesLength)
        );
    }

    public function value(): array
    {
        return array(
            'data' => $this->data,
            'accessRights' => $this->accessRights,
        );
    }

    public function clType(): CLURefType
    {
        return new CLURefType();
    }

    public function toBytes(): array
    {
        return array_merge($this->data, [$this->accessRights]);
    }

    public function toString(): string
    {
        // TODO: Implement toString() method.
        return '';
    }

    /**
     * @param int[] $urefAddress
     * @throws \Exception
     */
    private function assertURefAddressIsValid(array $urefAddress): void
    {
        if (!ByteUtil::isByteArray($urefAddress)) {
            throw new \Exception('$urefAddress should be byte array');
        }

        if (count($urefAddress) !== self::UREF_ADDRESS_LENGTH) {
            throw new \Exception('The length of URefAddress should be 32');
        }
    }

    /**
     * @throws \Exception
     */
    private function assertAccessRightsIsValid(int $accessRights): void
    {
        if (!in_array($accessRights, self::ACCESS_RIGHTS)) {
            throw new \Exception('Unsupported access rights');
        }
    }
}
