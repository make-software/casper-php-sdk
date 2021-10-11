<?php

namespace Casper\Entity;

use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
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

use Casper\Serializer\Secp256K1HexSignatureSerializer;
use Casper\Util\ByteUtil;

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
        $privateKeyByteArray = ByteUtil::hexToByteArray($this->encodeHex((string) $this->secpPrivateKey->getSecret(), false));

        $this->secpPublicKey = $this->secpPrivateKey->getPublicKey();
        $xHex = str_pad($this->encodeHex((string) $this->secpPublicKey->getPoint()->getX(), false), 64, "0", STR_PAD_LEFT);
        $compressedPublicKeyPrefix = $this->Modulo((string) $this->secpPublicKey->getPoint()->getY(), '2') === '1' ? '03' : '02';
        $publicKeyCompressedByteArray = ByteUtil::hexToByteArray($compressedPublicKeyPrefix . $xHex);

        parent::__construct($publicKeyCompressedByteArray, $privateKeyByteArray, self::ALGO_SECP255K1);
    }

    /**
     * @throws \Exception
     */
    public static function parsePrivateKeyFile(string $privateKeyPath): self
    {
        $adapter = EccFactory::getAdapter();
        $privateKeySerializer = new PemPrivateKeySerializer(new DerPrivateKeySerializer($adapter));

        return new self(
            $privateKeySerializer->parse(file_get_contents($privateKeyPath))
        );
    }

    public function exportPublicKeyInPem(): string
    {
        return $this->publicKeySerializer->serialize($this->secpPublicKey);
    }

    public function exportPrivateKeyInPem(): string
    {
        return $this->privateKeySerializer->serialize($this->secpPrivateKey);
    }

    /**
     * @throws \Exception
     */
    public function sign(array $message): array
    {
        $hasher = new SignHasher(self::HASHING_ALGORITHM, $this->adapter);
        $hash = $hasher->makeHash(ByteUtil::byteArrayToString($message), $this->generator);

        $random = RandomGeneratorFactory::getRandomGenerator();
        $randomK = $random->generate($this->generator->getOrder());

        $signer = new Signer($this->adapter);
        $signature = (new Secp256K1HexSignatureSerializer())
            ->serialize($signer->sign($this->secpPrivateKey, $hash, $randomK));

        return ByteUtil::hexToByteArray($signature);
    }

    public function verify(array $signature, array $message): bool
    {
        try {
            $signature = (new Secp256K1HexSignatureSerializer())
                ->parse(ByteUtil::byteArrayToHex($signature));

            $hasher = new SignHasher(self::HASHING_ALGORITHM);
            $hash = $hasher->makeHash(ByteUtil::byteArrayToString($message), $this->generator);

            return (new Signer($this->adapter))
                ->verify($this->secpPublicKey, $signature, $hash);
        } catch (\Exception $e) {
            return false;
        }
    }
}
