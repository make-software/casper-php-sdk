<?php

namespace Tests\Unit\Util\Crypto;

use PHPUnit\Framework\TestCase;

use Casper\Util\Crypto\Secp256K1Key;

class Secp256K1KeyTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testCreateNewSecp256K1FromFile(): void
    {
        $compressedPublicKeyValue = '02c6d103561f83a41281d278e07e45905529bf25d74fa184631a309afe7bc3dc06';
        $secp256k1KeyPair = Secp256K1Key::createFromPrivateKeyFile('tests/Assets/Secp256K1SecretKey.pem');

        $this->assertEquals($compressedPublicKeyValue, $secp256k1KeyPair->getPublicKey());
    }

    /**
     * @throws \Exception
     */
    public function testCantCreateNewSecp256K1FromWrongFile(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid data.');
        Secp256K1Key::createFromPrivateKeyFile('tests/Assets/Ed25519SecretKey.pem');
    }

    /**
     * @throws \Exception
     */
    public function testExportPublicKeyInPem(): void
    {
        $publicKeyInPem = file_get_contents('tests/Assets/Secp256K1PublicKey.pem');
        $secp256k1KeyPair = Secp256K1Key::createFromPrivateKeyFile('tests/Assets/Secp256K1SecretKey.pem');

        $this->assertEquals($publicKeyInPem, $secp256k1KeyPair->exportPublicKeyInPem());
    }

    /**
     * @throws \Exception
     */
    public function testExportPrivateKeyInPem(): void
    {
        $privateKeyInPem = file_get_contents('tests/Assets/Secp256K1SecretKey.pem');
        $secp256k1KeyPair = Secp256K1Key::createFromPrivateKeyFile('tests/Assets/Secp256K1SecretKey.pem');

        $this->assertEquals($privateKeyInPem, $secp256k1KeyPair->exportPrivateKeyInPem());
    }

    /**
     * @throws \Exception
     */
    public function testSigningAndVerification(): void
    {
        $message = 'Hello world';
        $secp256k1KeyPair = Secp256K1Key::createFromPrivateKeyFile('tests/Assets/Secp256K1SecretKey.pem');

        $signature = $secp256k1KeyPair->sign($message);
        $isVerified = $secp256k1KeyPair->verify($signature, $message);
        $this->assertTrue($isVerified);

        $corruptedSignature = str_replace('3', '2', $signature);
        $isVerified = $secp256k1KeyPair->verify($corruptedSignature, $message);
        $this->assertFalse($isVerified);
    }
}
