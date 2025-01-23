<?php

namespace Casper\Util\Crypto;

use Casper\Util\ByteUtil;

use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
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

use Casper\Util\NumUtil;

/**
 * Secp256K1 key implementation
 */
final class Secp256K1Key extends AsymmetricKey
{
    private const HASHING_ALGORITHM = 'sha256';

    private GmpMathInterface $adapter;

    private GeneratorPoint $generator;

    private PrivateKeyInterface $privateKeyObject;

    public function __construct(PrivateKeyInterface $privateKeyObject = null)
    {
        $this->adapter = EccFactory::getAdapter();
        $this->generator = EccFactory::getSecgCurves()
            ->generator256k1(null, true);
        $this->privateKeyObject = $privateKeyObject ?? EccFactory::getSecgCurves()
                ->generator256k1()
                ->createPrivateKey();

        $privateKey = ByteUtil::hexToString(gmp_strval($this->privateKeyObject->getSecret(), 16));
        $publicKey = ByteUtil::hexToString($this->getCompressedPublicKeyHex());

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
     */
    public function exportPublicKeyInPem(): string
    {
        return (new PemPublicKeySerializer(new DerPublicKeySerializer()))
                ->serialize($this->privateKeyObject->getPublicKey()) . PHP_EOL;
    }

    /**
     * @inheritDoc
     */
    public function exportPrivateKeyInPem(): string
    {
        return (new PemPrivateKeySerializer(new DerPrivateKeySerializer()))
                ->serialize($this->privateKeyObject) . PHP_EOL;
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function sign(string $message): string
    {
        $hash = (new SignHasher('sha256', $this->adapter))
            ->makeHash($message, $this->generator);

        $randomK = RandomGeneratorFactory::getHmacRandomGenerator($this->privateKeyObject, $hash, self::HASHING_ALGORITHM)
            ->generate($this->generator->getOrder());

        $signature = (new Signer($this->adapter, true))
            ->sign($this->privateKeyObject, $hash, $randomK);

        $r = $signature->getR();
        $s = $signature->getS();

        return NumUtil::padNumberLeft($r) . NumUtil::padNumberLeft($s);
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function verify(string $hexSignature, string $message): bool
    {
        try {
            $hash = (new SignHasher(self::HASHING_ALGORITHM))->makeHash($message, $this->generator);
            $publicKey = $this->privateKeyObject->getPublicKey();
            $signature = $this->hexToSignature($hexSignature);

            return (new Signer($this->adapter))
                ->verify($publicKey, $signature, $hash);
        } catch (\Exception $e) {
            return false;
        }
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

    private function hexToSignature(string $hex): SignatureInterface
    {
        $hex = mb_strtolower($hex);

        if (strpos($hex, '0x') >= 0) {
            $hex = str_replace('0x', '', $hex);
        }

        if (mb_strlen($hex) !== 128) {
            throw new \InvalidArgumentException('Incorrect hex length');
        }

        $rHex = mb_substr($hex, 0, 64);
        $sHex = mb_substr($hex, 64, 64);

        $r = gmp_init($rHex, 16);
        $s = gmp_init($sHex, 16);

        return new Signature($r, $s);
    }
}
