<?php

namespace Casper\Entity;

use Casper\CLType\CLPublicKey;
use Casper\CLType\CLPublicKeyTag;

abstract class AsymmetricKey
{
    protected const PEM_PUBLIC_KEY_TAG = 'PUBLIC KEY';
    protected const PEM_PRIVATE_KEY_TAG = 'PRIVATE KEY';

    protected const ALGO_ED25519 = 1;
    protected const ALGO_SECP255K1 = 2;

    protected CLPublicKey $publicKey;
    protected array $privateKey;
    protected int $signatureAlgorithm;

    /**
     * @param int[] $publicKey
     * @param int[] $privateKey
     * @param int $signatureAlgorithm
     *
     * @throws \Exception
     */
    public function __construct(
        array $publicKey,
        array $privateKey,
        int $signatureAlgorithm
    ) {
        $this->publicKey = new CLPublicKey($publicKey, new CLPublicKeyTag($signatureAlgorithm));
        $this->privateKey = $privateKey;
        $this->signatureAlgorithm = $signatureAlgorithm;
    }

    /**
     * Export the public key encoded in pem
     */
    abstract public function exportPublicKeyInPem(): string;

    /**
     * Export the private key encoded in pem
     */
    abstract public function exportPrivateKeyInPem(): string;

    /**
     * Sign the message by using the keyPair
     */
    abstract public function sign(array $message): array;

    /**
     * Verify the signature along with the raw message
     */
    public abstract function verify(array $signature, array $message): bool;

    public function getPublicKey(): CLPublicKey
    {
        return $this->publicKey;
    }

    /**
     * @throws \Exception
     */
    public function accountHash(): array
    {
        return $this->publicKey->toAccountHash();
    }

    public function accountHex(): string
    {
        return $this->publicKey->toHex();
    }

    protected function toPem(string $tag, string $content): string
    {
        return "-----BEGIN $tag-----\n$content\n-----END PUBLIC KEY-----\n";
    }
}
