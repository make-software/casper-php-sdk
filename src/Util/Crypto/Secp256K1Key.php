<?php

namespace Casper\Util\Crypto;

use Casper\Util\ByteUtil;

use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
use Mdanter\Ecc\Crypto\Signature\Signature;
use Mdanter\Ecc\Crypto\Signature\SignatureInterface;
use Mdanter\Ecc\Crypto\Signature\Signer;
use Mdanter\Ecc\Crypto\Signature\SignHasher;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Math\GmpMathInterface;
use Mdanter\Ecc\Primitives\GeneratorPoint;
use Mdanter\Ecc\Random\RandomGeneratorFactory;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\DerPublicKeySerializer;
use Mdanter\Ecc\Serializer\PublicKey\PemPublicKeySerializer;
use Phactor\Math;

/**
 * Secp255K1 key implementation
 */
final class Secp256K1Key extends AsymmetricKey
{
    use Math;

    protected const HASHING_ALGORITHM = 'sha256';

    protected GmpMathInterface $adapter;

    protected GeneratorPoint $generator;

    protected PemPrivateKeySerializer $privateKeySerializer;

    protected PemPublicKeySerializer $publicKeySerializer;

    protected PrivateKeyInterface $secpPrivateKey;

    protected PublicKeyInterface $secpPublicKey;

    public function __construct(PrivateKeyInterface $privateKey = null)
    {
        $this->adapter = EccFactory::getAdapter();
        $this->generator = EccFactory::getSecgCurves()->generator256k1();
        $this->privateKeySerializer = new PemPrivateKeySerializer(new DerPrivateKeySerializer($this->adapter));
        $this->publicKeySerializer = new PemPublicKeySerializer(new DerPublicKeySerializer($this->adapter));

        $this->secpPrivateKey = $privateKey ?? $this->generator->createPrivateKey();
        $privateKeyString = ByteUtil::hexToString($this->encodeHex((string) $this->secpPrivateKey->getSecret(), false));

        $this->secpPublicKey = $this->secpPrivateKey->getPublicKey();
        $xHex = str_pad($this->encodeHex((string) $this->secpPublicKey->getPoint()->getX(), false), 64, "0", STR_PAD_LEFT);
        $compressedPublicKeyPrefix = $this->Modulo((string) $this->secpPublicKey->getPoint()->getY(), '2') === '1' ? '03' : '02';
        $publicKeyCompressedString = ByteUtil::hexToString($compressedPublicKeyPrefix . $xHex);

        parent::__construct($publicKeyCompressedString, $privateKeyString, self::ALGO_SECP255K1);
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public static function createFromPrivateKeyFile(string $pathToPrivateKey): self
    {
        $adapter = EccFactory::getAdapter();
        $privateKeySerializer = new PemPrivateKeySerializer(new DerPrivateKeySerializer($adapter));

        return new self(
            $privateKeySerializer->parse(file_get_contents($pathToPrivateKey))
        );
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function exportPublicKeyInPem(): string
    {
        return $this->publicKeySerializer->serialize($this->secpPublicKey) . PHP_EOL;
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function exportPrivateKeyInPem(): string
    {
        return $this->privateKeySerializer->serialize($this->secpPrivateKey) . PHP_EOL;
    }

    /**
     * @inheritDoc
     * @param string $message
     * @return string
     */
    public function sign(string $message): string
    {
        $hasher = new SignHasher(self::HASHING_ALGORITHM, $this->adapter);
        $hash = $hasher->makeHash($message, $this->generator);

        $random = RandomGeneratorFactory::getRandomGenerator();
        $randomK = $random->generate($this->generator->getOrder());

        $signature = (new Signer($this->adapter))
            ->sign($this->secpPrivateKey, $hash, $randomK);

        return $this->signatureToHex($signature);
    }

    /**
     * @inheritDoc
     * @param string $signature
     * @param string $message
     * @return bool
     */
    public function verify(string $signature, string $message): bool
    {
        try {
            $signature = $this->hexToSignature($signature);

            $hasher = new SignHasher(self::HASHING_ALGORITHM);
            $hash = $hasher->makeHash($message, $this->generator);

            return (new Signer($this->adapter))
                ->verify($this->secpPublicKey, $signature, $hash);
        } catch (\Exception $e) {
            return false;
        }
    }

    private function signatureToHex(SignatureInterface $signature): string
    {
        $r = $signature->getR();
        $s = $signature->getS();

        return gmp_strval($r, 16) . gmp_strval($s, 16);
    }

    private function hexToSignature(string $hex): SignatureInterface
    {
        $hex = mb_strtolower($hex);

        if (strpos($hex, '0x') >= 0) {
            $count = 1;
            $hex = str_replace('0x', '', $hex, $count);
        }

        if (mb_strlen($hex) !== 128) {
            throw new \InvalidArgumentException('Binary string was not correct.');
        }

        $r = mb_substr($hex, 0, 64);
        $s = mb_substr($hex, 64, 64);

        return new Signature(gmp_init($r, 16), gmp_init($s, 16));
    }
}
