<?php

namespace Casper\Util\Crypto;

use Casper\Util\ByteUtil;

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

    public function getPublicKey(): string
    {
        return ByteUtil::stringToHex($this->publicKey);
    }

    abstract public static function createFromPrivateKeyFile(string $pathToPrivateKey): self;

    abstract public function exportPublicKeyInPem(): string;

    abstract public function exportPrivateKeyInPem(): string;

    abstract public function sign(string $message): string;

    public abstract function verify(string $signature, string $message): bool;
}
