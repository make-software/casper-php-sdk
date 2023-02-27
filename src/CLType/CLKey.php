<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

final class CLKey extends CLValue
{
    private const KEY_TYPE_ACCOUNT = 0;
    private const KEY_TYPE_HASH = 1;
    private const KEY_TYPE_UREF = 2;

    private const KEY_TYPES_MAP = array(
        CLAccountHash::class => self::KEY_TYPE_ACCOUNT,
        CLByteArray::class => self::KEY_TYPE_HASH,
        CLURef::class => self::KEY_TYPE_UREF,
    );

    /**
     * @param CLByteArray|CLURef|CLAccountHash|CLPublicKey $keyParam
     * @throws \Exception
     */
    public function __construct($keyParam)
    {
        $this->assertCLKeyParametersAreValid($keyParam);

        if ($keyParam instanceof CLPublicKey) {
            $this->data = new CLAccountHash($keyParam->toAccountHash());
            return;
        }

        $this->data = $keyParam;
    }

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        if (count($bytes) < 1) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
        }

        $tag = $bytes[0];

        switch ($tag) {
            case self::KEY_TYPE_HASH:
                $value = new self(CLByteArray::fromBytes(array_slice($bytes, 1, CLAccountHash::ACCOUNT_HASH_LENGTH)));
                break;
            case self::KEY_TYPE_UREF:
                $value = new self(CLURef::fromBytes(array_slice($bytes, 1)));
                break;
            case self::KEY_TYPE_ACCOUNT:
                $value = new self(CLAccountHash::fromBytes(array_slice($bytes, 1)));
                break;
            default:
                self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_FORMATTING);
        }

        return new CLValueWithRemainder($value, []);
    }

    /**
     * @return CLByteArray|CLURef|CLAccountHash
     */
    public function value()
    {
        return $this->data;
    }

    public function clType(): CLKeyType
    {
        return new CLKeyType();
    }

    public function toBytes(): array
    {
        return array_merge(
            [self::KEY_TYPES_MAP[get_class($this->data)]],
            $this->data->toBytes()
        );
    }

    public function parsedValue(): string
    {
        return ByteUtil::byteArrayToHex($this->toBytes());
    }

    public function isHash(): bool
    {
        return $this->data instanceof CLByteArray;
    }

    public function isURef(): bool
    {
        return $this->data instanceof CLURef;
    }

    public function isAccount(): bool
    {
        return $this->data instanceof CLAccountHash;
    }

    /**
     * @param mixed $keyParam
     * @throws \Exception
     */
    private function assertCLKeyParametersAreValid($keyParam): void
    {
        $availableParams = [
            CLByteArray::class,
            CLURef::class,
            CLAccountHash::class,
            CLPublicKey::class,
        ];

        if (!is_object($keyParam) || !in_array(get_class($keyParam), $availableParams)) {
            throw new \Exception('Invalid key param');
        }
    }
}
