<?php

namespace Casper\Util\Crypto;

use Casper\Util\ByteUtil;
use Casper\Util\KeysUtil;

final class Ed25519Key extends AsymmetricKey
{
    /**
     * @throws \Exception
     */
    public function __construct(string $publicKey = '', string $privateKey = '')
    {
        if (empty($publicKey) && empty($privateKey)) {
            $keyPair = sodium_crypto_sign_keypair();
            $publicKey = sodium_crypto_sign_publickey($keyPair);
            $privateKey = sodium_crypto_sign_secretkey($keyPair);
        }

        parent::__construct($publicKey, $privateKey, self::ALGO_ED25519);
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public static function createFromPrivateKeyFile(string $pathToPrivateKey): self
    {
        $privateKeyFromPem = self::parsePrivateKey(
            KeysUtil::readBase64WithPEM(file_get_contents($pathToPrivateKey))
        );
        $publicKey = self::privateToPublicKey($privateKeyFromPem);
        $privateKey = $privateKeyFromPem . $publicKey;

        return new self($publicKey, $privateKey);
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function exportPublicKeyInPem(): string
    {
        $derPrefix = ByteUtil::byteArrayToString([48, 42, 48, 5, 6, 3, 43, 101, 112, 3, 33, 0]);
        $encoded = base64_encode($derPrefix . $this->publicKey);

        return "-----BEGIN PUBLIC KEY-----\n$encoded\n-----END PUBLIC KEY-----\n";
    }

    /**
     * @inheritDoc
     * @return string
     *
     * @throws \Exception
     */
    public function exportPrivateKeyInPem(): string
    {
        $derPrefix = ByteUtil::byteArrayToString([48, 46, 2, 1, 0, 48, 5, 6, 3, 43, 101, 112, 4, 34, 4, 32]);
        $encoded = base64_encode($derPrefix . self::parsePrivateKey($this->privateKey));

        return "-----BEGIN PRIVATE KEY-----\n$encoded\n-----END PRIVATE KEY-----\n";
    }

    /**
     * @inheritDoc
     * @return string
     *
     * @throws \Exception
     */
    public function sign(string $message): string
    {
        return ByteUtil::stringToHex(sodium_crypto_sign_detached($message, $this->privateKey));
    }

    /**
     * @inheritDoc
     * @return string
     *
     * @throws \SodiumException
     */
    public function verify(string $hexSignature, string $message): bool
    {
        $hexSignature = ByteUtil::hexToString($hexSignature);
        return sodium_crypto_sign_verify_detached($hexSignature, $message, $this->publicKey);
    }

    /**
     * @throws \Exception
     */
    private static function privateToPublicKey(string $privateKey): string
    {
        $secretKeyBytes = 64;

        return count(ByteUtil::stringToByteArray($privateKey)) === $secretKeyBytes
            ? sodium_crypto_sign_publickey_from_secretkey($privateKey)
            : sodium_crypto_sign_publickey(sodium_crypto_sign_seed_keypair($privateKey));
    }

    /**
     * @throws \Exception
     */
    private static function parsePrivateKey(string $privateKey): string
    {
        return self::parseKey($privateKey, 0, 32);
    }

    /**
     * @throws \Exception
     */
    private static function parseKey(string $keyString, int $from, int $to): string
    {
        $keyBytes = ByteUtil::stringToByteArray($keyString);
        $length = count($keyBytes);

        if ($length === 32) {
            $key = $keyBytes;
        }
        else if ($length === 64) {
            $key = array_slice($keyBytes, $from, $to);
        }
        else if ($length > 32 && $length < 64) {
            $key = array_slice($keyBytes, $length % 32);
        }
        else {
            $key = null;
        }

        if ($key === null || count($key) !== 32) {
            throw new \Exception('Unexpected key length');
        }

        return ByteUtil::byteArrayToString($key);
    }
}
