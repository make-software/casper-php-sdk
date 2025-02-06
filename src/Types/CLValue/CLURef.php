<?php

namespace Casper\Types\CLValue;

use Casper\Types\CLValue\CLType\CLType;
use Casper\Types\CLValue\CLType\CLURefType;
use Casper\Util\ByteUtil;

final class CLURef extends CLValue
{
    private const UREF_ACCESS_RIGHTS_LENGTH = 1;
    private const UREF_ADDRESS_LENGTH = 32;

    public const UREF_PREFIX = 'uref-';

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
     * @throws \Exception
     */
    public static function fromString(string $uref): self
    {
        $prefix = substr($uref, 0, 5);
        $accessRights = substr($uref, -4);

        if ($prefix !== self::UREF_PREFIX || !preg_match('/-\d{3}$/', $accessRights)) {
            throw new \Exception('Invalid uref string');
        }

        $urefAddressBytes = ByteUtil::hexToByteArray(substr(str_replace(self::UREF_PREFIX, '', $uref), 0, -4));
        $accessRights = (int) str_replace('-', '', $accessRights);

        return new self($urefAddressBytes, $accessRights);
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

    public function parsedValue(): string
    {
        return self::UREF_PREFIX . ByteUtil::byteArrayToHex($this->data)
            . '-' . str_pad($this->accessRights, 3, '0', STR_PAD_LEFT);
    }

    /**
     * @param int[] $urefAddress
     * @throws \Exception
     */
    private function assertURefAddressIsValid(array $urefAddress): void
    {
        if (!ByteUtil::isByteArray($urefAddress)) {
            $message = '$urefAddress should be byte array';
        }
        else if (count($urefAddress) !== self::UREF_ADDRESS_LENGTH) {
            $message = 'The length of URefAddress should be 32';
        }

        if (isset($message)) {
            throw new \Exception($message);
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
