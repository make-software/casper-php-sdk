<?php

namespace Casper\Util\Crypto;

use Casper\Util\ByteUtil;

use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\PemPublicKeySerializer;

/**
 * Secp256K1 key implementation
 */
final class Secp256K1Key extends AsymmetricKey
{
    protected const RESULT_OK = 1;
    protected const HASHING_ALGORITHM = 'sha256';

    protected PrivateKeyInterface $privateKeyObject;

    public function __construct(PrivateKeyInterface $privateKeyObject = null)
    {
        $this->privateKeyObject = $privateKeyObject ??
            EccFactory::getSecgCurves()
                ->generator256k1()
                ->createPrivateKey();

        $privateKey = ByteUtil::hexToString(gmp_strval($this->privateKeyObject->getSecret(), 16));
        $publicKey= ByteUtil::hexToString($this->getCompressedPublicKeyHex());

        parent::__construct($publicKey, $privateKey, self::ALGO_SECP255K1);
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public static function createFromPrivateKeyFile(string $pathToPrivateKey): self
    {
        return new self(
            (new PemPrivateKeySerializer(new DerPrivateKeySerializer()))
                ->parse(file_get_contents($pathToPrivateKey))
        );
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function exportPublicKeyInPem(): string
    {
        return (new PemPublicKeySerializer(new DerPublicKeySerializer()))
                ->serialize($this->privateKeyObject->getPublicKey()) . PHP_EOL;
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function exportPrivateKeyInPem(): string
    {
        return (new PemPrivateKeySerializer(new DerPrivateKeySerializer()))
                ->serialize($this->privateKeyObject) . PHP_EOL;
    }

    /**
     * @inheritDoc
     * @param string $message
     * @return string
     *
     * @throws \Exception
     */
    public function sign(string $message): string
    {
        $context = secp256k1_context_create(SECP256K1_CONTEXT_SIGN | SECP256K1_CONTEXT_VERIFY);

        $signature = null;
        $signResult = secp256k1_ecdsa_sign(
            $context,
            $signature,
            hash(self::HASHING_ALGORITHM, $message, true),
            $this->privateKey
        );

        if ($signResult !== self::RESULT_OK) {
            throw new \Exception("Failed to create signature");
        }

        $signatureSerialized = '';
        secp256k1_ecdsa_signature_serialize_compact($context, $signatureSerialized, $signature);

        return ByteUtil::stringToHex($signatureSerialized);
    }

    /**
     * @inheritDoc
     * @param string $hexSignature
     * @param string $message
     * @return bool
     *
     * @throws \Exception
     */
    public function verify(string $hexSignature, string $message): bool
    {
        $context = secp256k1_context_create(SECP256K1_CONTEXT_SIGN | SECP256K1_CONTEXT_VERIFY);

        $publicKey = null;
        $publicKeyParseResult = secp256k1_ec_pubkey_parse($context, $publicKey, $this->publicKey);

        if ($publicKeyParseResult !== self::RESULT_OK) {
            throw new \Exception("Failed to parse public key");
        }

        $signature = null;
        $signatureParseResult = secp256k1_ecdsa_signature_parse_compact(
            $context,
            $signature,
            ByteUtil::hexToString($hexSignature)
        );

        if ($signatureParseResult !== self::RESULT_OK) {
            throw new \Exception("Failed to parse DER signature");
        }

        $isVerified = secp256k1_ecdsa_verify(
            $context,
            $signature,
            hash(self::HASHING_ALGORITHM, $message, true),
            $publicKey
        );

        return $isVerified === self::RESULT_OK;
    }

    private function getCompressedPublicKeyHex(): string
    {
        $xPointValue = $this->privateKeyObject
            ->getPublicKey()
            ->getPoint()
            ->getX();

        $yPointValue = $this->privateKeyObject
            ->getPublicKey()
            ->getPoint()
            ->getY();

        $xPointValueHex = str_pad(gmp_strval($xPointValue, 16), 64, '0', STR_PAD_LEFT);
        $prefix = gmp_strval(gmp_mod($yPointValue, 2)) === '1' ? '03' : '02';

        return $prefix . $xPointValueHex;
    }
}
