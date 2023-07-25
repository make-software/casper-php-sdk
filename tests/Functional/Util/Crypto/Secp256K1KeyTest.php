<?php

namespace Tests\Functional\Util\Crypto;

use Casper\Util\ByteUtil;
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
     * Test hashes that were incorrectly signed with Mdanter\Ecc\Crypto\Signature\Signer
     * For tested hashes Mdanter\Ecc\Crypto\Signature\Signer calculates wrong S value
     *
     * Fixed bug by installing https://github.com/Bit-Wasp/secp256k1-php and
     * replacing signature creation with method from the installed lib instead of
     * Mdanter\Ecc\Crypto\Signature\Signer
     *
     * @throws \Exception
     */
    public function testSigning(): void
    {
        $hash1 = '7603b5b40d32cffd00d375de90b4610c6b3fcb7fd4cceefe408d23453f42e482';
        $hash2 = '2225cb72ec2058fa153c2b494e416a336f48b0b89ba4fc444151e708907fd53a';
        $hash3 = 'c02fd8c56ee37fa4ba6bf260742c21cd0d427914f3cac266bf58266decb4c77d';
        $hash4 = '766d28afb40744c703591334ecc02d18faee90f420159eb4b542915ff7589e25';
        $hash5 = '8f5a6f914d39149fc7ee4d3318e899bf3c7ecf54e63a64d6c715a33c4f47374d';

        $correctSignatureForHash1 = 'b23038d56a9b7d025453c6d0288be95bccdf5b29e327be89baa143df7f88d57a3d9ab479b353d6604d084a9296fc76a1f4020ee639744ba61430e51b0df423ac';
        $correctSignatureForHash2 = '79b77c21e0db001eda6f79fbd3ae92e3022d55b07dc3fa4d932dc38abd7933c7224243f0a4f7a133ccd966389012c493dd9e2dc7b69f118465305f6efdfc1fd5';
        $correctSignatureForHash3 = '065a3d85843334ab9fbf5998aa28c2f8b997989764591f781372386c1009ae5766560182f77ae3917198eb62d969582c4ec7e0bad99e33759d5d8ec84910d980';
        $correctSignatureForHash4 = '02f1ca3e4f58d1f2ba64ad55893a87a442e63b7fae7df7eb883ded7ad22f92af06e4b96d78b150fd9bf8603e4e4fcee45a49704aacfcfe1ebd3702a8a6a5d929';
        $correctSignatureForHash5 = 'f0d1775662db12dc7bfde1779b9a9bfbf0d1497e04e7b1fd253a3d3b7726c6f873dea751d162cb1f017f954d3f1d41bae8f115451042665c5b02411560479b7a';

        $secp256k1KeyPair = Secp256K1Key::createFromPrivateKeyFile('tests/Assets/Secp256K1SecretKey.pem');

        $this->assertEquals($correctSignatureForHash1, $secp256k1KeyPair->sign(ByteUtil::hexToString($hash1)));
        $this->assertEquals($correctSignatureForHash2, $secp256k1KeyPair->sign(ByteUtil::hexToString($hash2)));
        $this->assertEquals($correctSignatureForHash3, $secp256k1KeyPair->sign(ByteUtil::hexToString($hash3)));
        $this->assertEquals($correctSignatureForHash4, $secp256k1KeyPair->sign(ByteUtil::hexToString($hash4)));
        $this->assertEquals($correctSignatureForHash5, $secp256k1KeyPair->sign(ByteUtil::hexToString($hash5)));
    }

    /**
     * @throws \Exception
     */
    public function testSignatureVerification(): void
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
