<?php

namespace Casper\Types\CLValue;

use Casper\Types\CLValue\CLType\CLPublicKeyType;
use Casper\Types\CLValue\CLType\CLType;
use Casper\Util\ByteUtil;
use Casper\Util\HashUtil;
use Casper\Util\Crypto\AsymmetricKey;
use Casper\Util\KeysUtil;

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
    public static function fromAsymmetricKey(AsymmetricKey $asymmetricKey): self
    {
        return self::fromHex(
            KeysUtil::addPrefixToPublicKey($asymmetricKey->getSignatureAlgorithm(), $asymmetricKey->getPublicKey())
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromHex(string $string): self
    {
        if (strlen($string) < 2) {
            throw new \Exception('Asymmetric key error: too short');
        }

        $bytes = ByteUtil::hexToByteArray($string);
        $publicKeyTag = $bytes[0];
        $publicKeyBytes = array_slice($bytes, 1);

        return new self($publicKeyBytes, new CLPublicKeyTag($publicKeyTag));
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

    public function toHex(): string
    {
        return '0' . $this->tag()->getTagValue() . ByteUtil::byteArrayToHex($this->value());
    }

    /**
     * @throws \Exception
     */
    public function toAccountHashString(): string
    {
        return CLAccountHash::ACCOUNT_HASH_PREFIX . ByteUtil::byteArrayToHex($this->toAccountHash());
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
