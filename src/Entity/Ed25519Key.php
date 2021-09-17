<?php

namespace Casper\Entity;

use Casper\Util\ByteUtil;
use Casper\Util\KeysUtil;

final class Ed25519Key extends AsymmetricKey
{
    /**
     * @throws \Exception
     */
    public function __construct(array $publicKey, array $privateKey)
    {
        parent::__construct($publicKey, $privateKey, self::ALGO_ED25519);
    }

    /**
     * @throws \SodiumException
     * @throws \Exception
     */
    public static function new(): self
    {
        $keyPair = sodium_crypto_sign_keypair();

        return new self(
            ByteUtil::stringToByteArray(sodium_crypto_sign_publickey($keyPair)),
            ByteUtil::stringToByteArray(sodium_crypto_sign_secretkey($keyPair))
        );
    }

    public static function accountHexForPublicKey(array $publicKey): string
    {
        return '0' . self::ALGO_ED25519 . ByteUtil::byteArrayToHex($publicKey);
    }

    /**
     * @throws \Exception
     */
    public static function parseKeyFiles(string $publicKeyPath, string $privateKeyPath): self
    {
        $publicKey = self::parsePublicKeyFile($publicKeyPath);
        $privateKey = self::parsePrivateKeyFile($privateKeyPath);
        $secret = array_merge($privateKey, $publicKey);

        return new self($publicKey, $secret);
    }

    /**
     * @throws \Exception
     */
    public static function parseKeyPair(array $publicKey, array $privateKey): self
    {
        $publicKey = self::parsePublicKey($publicKey);
        $privateKey = self::parsePrivateKey($privateKey);
        $secret = array_merge($privateKey, $publicKey);

        return new self($publicKey, $secret);
    }

    /**
     * @throws \Exception
     */
    public static function parsePrivateKeyFile(string $path): array
    {
        return self::parsePrivateKey(
            KeysUtil::readBase64WithPEM(file_get_contents($path))
        );
    }

    /**
     * @throws \Exception
     */
    public static function parsePublicKeyFile(string $path): array
    {
        return self::parsePublicKey(
            KeysUtil::readBase64WithPEM(file_get_contents($path))
        );
    }

    /**
     * @throws \Exception
     */
    public static function parsePrivateKey(array $bytes): array
    {
        return self::parseKey($bytes, 0, 32);
    }

    /**
     * @throws \Exception
     */
    public static function parsePublicKey(array $bytes): array
    {
        return self::parseKey($bytes, 32, 64);
    }

    /**
     * @throws \Exception
     */
    public static function privateToPublicKey(array $privateKey): array
    {
        $secretKeyBytes = 64;

        if (count($privateKey) === $secretKeyBytes) {
            $publicKey = sodium_crypto_sign_publickey_from_secretkey(
                ByteUtil::byteArrayToString($privateKey)
            );
        } else {
            $publicKey = sodium_crypto_sign_publickey(
                sodium_crypto_sign_seed_keypair(
                    ByteUtil::byteArrayToString($privateKey)
                )
            );
        }

        return ByteUtil::stringToByteArray($publicKey);
    }

    /**
     * @throws \Exception
     */
    private static function parseKey(array $bytes, int $from, int $to): array
    {
        $length = count($bytes);

        if ($length === 32) {
            $key = $bytes;
        }
        else if ($length === 64) {
            $key = array_slice($bytes, $from, $to);
        }
        else if ($length > 32 && $length < 64) {
            $key = array_slice($bytes, $length % 32);
        }
        else {
            $key = null;
        }

        if ($key === null || count($key) !== 32) {
            throw new \Exception('Unexpected key length: ' . count($key));
        }

        return $key;
    }

    public function exportPublicKeyInPem(): string
    {
        $derPrefix = [48, 42, 48, 5, 6, 3, 43, 101, 112, 3, 33, 0];
        $encoded = base64_encode(
            ByteUtil::byteArrayToString(
                array_merge($derPrefix, $this->publicKey->value())
            )
        );

        return $this->toPem(self::PEM_PUBLIC_KEY_TAG, $encoded);
    }

    /**
     * @throws \Exception
     */
    public function exportPrivateKeyInPem(): string
    {
        $derPrefix = [48, 46, 2, 1, 0, 48, 5, 6, 3, 43, 101, 112, 4, 34, 4, 32];
        $encoded = base64_encode(
            ByteUtil::byteArrayToString(
                array_merge($derPrefix, self::parsePrivateKey($this->privateKey))
            )
        );

        return $this->toPem(self::PEM_PRIVATE_KEY_TAG, $encoded);
    }

    /**
     * @throws \Exception
     */
    public function sign(array $message): array
    {
        return ByteUtil::stringToByteArray(
            sodium_crypto_sign_detached(
                ByteUtil::byteArrayToString($message),
                ByteUtil::byteArrayToString($this->privateKey)
            )
        );
    }

    /**
     * @throws \SodiumException
     */
    public function verify(array $signature, array $message): bool
    {
        return sodium_crypto_sign_verify_detached(
            ByteUtil::byteArrayToString($signature),
            ByteUtil::byteArrayToString($message),
            ByteUtil::byteArrayToString($this->publicKey->value())
        );
    }
}
