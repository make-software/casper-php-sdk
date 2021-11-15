<?php

namespace Tests\Unit\Util\Crypto;

use PHPUnit\Framework\TestCase;

use Casper\Util\Crypto\Ed25519Key;

class Ed25519KeyTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testCreateNewEd25519FromFile(): void
    {
        $publicKeyValue = 'd8c952c07d08c6ebecb47d5608616d5d7a2625a1053c8ccaa2c4605b15338cc7';
        $ed25519KeyPair = Ed25519Key::createFromPrivateKeyFile('tests/Assets/Ed25519SecretKey.pem');

        $this->assertEquals($publicKeyValue, $ed25519KeyPair->getPublicKey());
    }

    /**
     * @throws \Exception
     */
    public function testCantCreateNewEd25519FromWrongFile(): void
    {
        $this->expectException(\Exception::class);
        Ed25519Key::createFromPrivateKeyFile('tests/Assets/Secp256K1SecretKey.pem');
    }

    /**
     * @throws \Exception
     */
    public function testExportPublicKeyInPem(): void
    {
        $publicKeyInPem = file_get_contents('tests/Assets/Ed25519PublicKey.pem');
        $ed25519KeyPair = Ed25519Key::createFromPrivateKeyFile('tests/Assets/Ed25519SecretKey.pem');

        $this->assertEquals($publicKeyInPem, $ed25519KeyPair->exportPublicKeyInPem());
    }

    /**
     * @throws \Exception
     */
    public function testExportPrivateKeyInPem(): void
    {
        $privateKeyInPem = file_get_contents('tests/Assets/Ed25519SecretKey.pem');
        $ed25519KeyPair = Ed25519Key::createFromPrivateKeyFile('tests/Assets/Ed25519SecretKey.pem');

        $this->assertEquals($privateKeyInPem, $ed25519KeyPair->exportPrivateKeyInPem());
    }

    public function testSigningAndVerification(): void
    {
        $message = 'Hello world';
        $ed25519KeyPair = Ed25519Key::createFromPrivateKeyFile('tests/Assets/Ed25519SecretKey.pem');

        $signature = $ed25519KeyPair->sign($message);
        $isVerified = $ed25519KeyPair->verify($signature, $message);
        $this->assertTrue($isVerified);

        $corruptedSignature = str_replace('3', '2', $signature);
        $isVerified = $ed25519KeyPair->verify($corruptedSignature, $message);
        $this->assertFalse($isVerified);
    }
}
