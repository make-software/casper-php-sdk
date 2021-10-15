<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;
use Casper\Util\HashUtil;
use Casper\Util\Crypto\AsymmetricKey;

final class CLPublicKey extends CLValue
{
    public const ED25519_LENGTH = 32;
    public const SECP256K1_LENGTH = 33;

    public const KEY_TYPE_TO_KEY_LENGTH_MAP = array(
        AsymmetricKey::ALGO_ED25519 => CLPublicKey::ED25519_LENGTH,
        AsymmetricKey::ALGO_SECP255K1 => CLPublicKey::SECP256K1_LENGTH,
    );

    private CLPublicKeyTag $tag;

    /**
     * @throws \Exception
     */
    public function __construct(array $rawPublicKey, CLPublicKeyTag $tag)
    {
        $this->assertRawPublicKeyLengthIsValid($rawPublicKey, $tag);
        $this->data = $rawPublicKey;
        $this->tag = $tag;
    }

    /**
     * @throws \Exception
     */
    public static function fromBytesWithRemainder(array $bytes, ?CLType $innerType = null): CLValueWithRemainder
    {
        if (count($bytes) < 1) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_EARLY_END_OF_STREAM);
        }

        $keyType = $bytes[0];
        $keyLength = self::KEY_TYPE_TO_KEY_LENGTH_MAP[$keyType] ?? null;

        if (!$keyLength) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_FORMATTING);
        }

        return new CLValueWithRemainder(
            new self(array_slice($bytes, 1, $keyLength), new CLPublicKeyTag($keyType)),
            array_slice($bytes, $keyLength + 1)
        );
    }

    public function value(): array
    {
        return $this->data;
    }

    public function tag(): CLPublicKeyTag
    {
        return $this->tag;
    }

    public function clType(): CLPublicKeyType
    {
        return new CLPublicKeyType();
    }

    public function toBytes(): array
    {
        return array_merge([$this->tag->getTagValue()], $this->data);
    }

    public function parsedValue(): string
    {
        return ByteUtil::byteArrayToHex($this->toBytes());
    }

    /**
     * @throws \Exception
     */
    public function toAccountHash(): array
    {
        if (count($this->data) === 0) {
            return [];
        }

        $algorithmIdentifier = strtolower($this->tag->getTagName());
        $separator = [0];
        $prefix = array_merge(ByteUtil::stringToByteArray($algorithmIdentifier), $separator);

        return HashUtil::blake2bHash(array_merge($prefix, $this->data));
    }

    /**
     * @throws \Exception
     */
    public function toAccountHashString(): string
    {
        return ByteUtil::byteArrayToHex($this->toAccountHash());
    }

    /**
     * @throws \Exception
     */
    private function assertRawPublicKeyLengthIsValid(array $rawPublicKey, CLPublicKeyTag $tag): void
    {
        $keyLength = count($rawPublicKey);
        $tagValue = $tag->getTagValue();

        if ($tagValue === CLPublicKeyTag::ED25519 && $keyLength !== self::ED25519_LENGTH) {
            $message = 'Wrong length of ED25519 key. Expected ' . self::ED25519_LENGTH . ', but got ' . $keyLength;
        }
        else if ($tagValue === CLPublicKeyTag::SECP256K1 && $keyLength !== self::SECP256K1_LENGTH) {
            $message = 'Wrong length of SECP256K1 key. Expected ' . self::SECP256K1_LENGTH . ', but got ' . $keyLength;
        }

        if (isset($message)) {
            throw new \Exception($message);
        }
    }
}
