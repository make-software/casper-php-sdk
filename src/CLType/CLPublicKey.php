<?php

namespace Casper\CLType;

use Casper\Entity\AsymmetricKey;
use Casper\Interfaces\ToBytesInterface;
use Casper\Util\ByteUtil;
use Casper\Util\HashUtil;

final class CLPublicKey extends CLValue implements ToBytesInterface
{
    private const ED25519_LENGTH = 32;
    private const SECP256K1_LENGTH = 33;

    protected CLPublicKeyTag $tag;

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
    private function assertRawPublicKeyLengthIsValid(array $rawPublicKey, CLPublicKeyTag $tag): void
    {
        $keyLength = count($rawPublicKey);
        $tagValue = $tag->getTagValue();

        if ($tagValue === CLPublicKeyTag::ED25519 && $keyLength !== self::ED25519_LENGTH) {
            $message = 'Wrong length of ED25519 key. Expected' . self::ED25519_LENGTH . ', but got ' . $keyLength;
        }
        else if ($tagValue === CLPublicKeyTag::SECP256K1 && $keyLength !== self::SECP256K1_LENGTH) {
            $message = 'Wrong length of SECP256K1 key. Expected' . self::SECP256K1_LENGTH . ', but got ' . $keyLength;
        }

        if (isset($message)) {
            throw new \Exception($message);
        }
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
        $keyLength = AsymmetricKey::KEY_TYPE_TO_KEY_LENGTH_MAP[$keyType] ?? null;

        if (!$keyLength) {
            self::throwFromBytesCreationError(CLTypeTag::CL_ERROR_CODE_FORMATTING);
        }

        return new CLValueWithRemainder(
            new self(array_slice($bytes, 1, $keyLength), new CLPublicKeyTag($keyType)),
            array_slice($bytes, $keyLength + 1)
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromHex(string $publicKeyHex): self
    {
        if (strlen($publicKeyHex) < 2) {
            throw new \Exception('Asymmetric key error: too short');
        }

        $bytes = ByteUtil::hexToByteArray($publicKeyHex);
        return new self(
            array_slice($bytes, 1),
            new CLPublicKeyTag($bytes[0])
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromED5519(array $publicKey): self
    {
        return new self($publicKey, new CLPublicKeyTag(CLPublicKeyTag::ED25519));
    }

    /**
     * @throws \Exception
     */
    public static function fromSECP256K1(array $publicKey): self
    {
        return new self($publicKey, new CLPublicKeyTag(CLPublicKeyTag::SECP256K1));
    }

    /**
     * @return int[]
     */
    public function value(): array
    {
        return $this->data;
    }

    public function clType(): CLPublicKeyType
    {
        return new CLPublicKeyType();
    }

    /**
     * @return int[]
     */
    public function toBytes(): array
    {
        return array_merge([$this->tag->getTagValue()], $this->data);
    }

    public function isED25519(): bool
    {
        return $this->tag->getTagValue() === CLPublicKeyTag::ED25519;
    }

    public function isSECP256K1(): bool
    {
        return $this->tag->getTagValue() === CLPublicKeyTag::SECP256K1;
    }

    public function toHex(): string
    {
        return '0'
            . $this->tag->getTagValue()
            . ByteUtil::byteArrayToHex($this->data);
    }

    /**
     * @return int[]
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
        $bytes = $this->toAccountHash();
        $hashHex = ByteUtil::byteArrayToHex($bytes);

        return "account-hash-$hashHex";
    }
}
