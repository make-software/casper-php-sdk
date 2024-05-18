<?php

namespace Casper\Util\Crypto;

use Casper\Util\ByteUtil;

/**
 * Base class for asymmetric keys implementation
 */
abstract class AsymmetricKey
{
    public const ALGO_ED25519 = 1;
    public const ALGO_SECP255K1 = 2;

    public const SUPPORTED_SIGNATURE_ALGORITHM = [
        self::ALGO_ED25519,
        self::ALGO_SECP255K1,
    ];

    protected int $signatureAlgorithm;

    /**
     * Binary string
     *
     * @var string
     */
    protected string $publicKey;

    /**
     * Binary string
     *
     * @var string
     */
    protected string $privateKey;

    public function __construct(string $publicKey, string $privateKey, int $signatureAlgorithm)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->signatureAlgorithm = $signatureAlgorithm;
    }

    public function getSignatureAlgorithm(): int
    {
        return $this->signatureAlgorithm;
    }

    /**
     * Get public key hex-encoded string
     *
     * @return string
     */
    public function getPublicKey(): string
    {
        return ByteUtil::stringToHex($this->publicKey);
    }

    /**
     * Create AsymmetricKey instance from private key .pem file
     *
     * @param string $pathToPrivateKey
     * @return static
     */
    abstract public static function createFromPrivateKeyFile(string $pathToPrivateKey): self;

    /**
     * Get public key in PEM-formatted string
     *
     * @return string
     */
    abstract public function exportPublicKeyInPem(): string;

    /**
     * Get private key in PEM-formatted string
     *
     * @return string
     */
    abstract public function exportPrivateKeyInPem(): string;

    /**
     * Sign the message and return hex-encoded signature
     *
     * @param string $message
     * @return string
     */
    abstract public function sign(string $message): string;

    /**
     * Verify hex-encoded signature
     *
     * @param string $hexSignature
     * @param string $message
     * @return bool
     */
    public abstract function verify(string $hexSignature, string $message): bool;
}
