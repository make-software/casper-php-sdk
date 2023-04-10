<?php

namespace Tests\Functional\Util;

use PHPUnit\Framework\TestCase;

use Casper\Util\ByteUtil;
use Casper\Util\CEP57ChecksumUtil;

class CEP57ChecksumUtilTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testHasCheckSum(): void
    {
        $hexWithCheckSum = 'dE8649985929090B7Cb225e35a5a7B4087Fb8FCB3D18c8c9a58da68e4eDA8A2e';
        $this->assertTrue(CEP57ChecksumUtil::hasChecksum($hexWithCheckSum));

        $hexWithoutCheckSum = 'de8649985929090b7cb225e35a5a7b4087fb8fcb3d18c8c9a58da68e4eda8a2e';
        $this->assertFalse(CEP57ChecksumUtil::hasChecksum($hexWithoutCheckSum));
    }

    /**
     * @throws \Exception
     */
    public function testEncode(): void
    {
        $hex = 'dE8649985929090B7Cb225e35a5a7B4087Fb8FCB3D18c8c9a58da68e4eDA8A2e';
        $bytes = ByteUtil::hexToByteArray($hex);

        $encodedHex = CEP57ChecksumUtil::encode($bytes);
        $this->assertEquals($hex, $encodedHex);
    }

    /**
     * @throws \Exception
     */
    public function testDecode(): void
    {
        $hex = 'dE8649985929090B7Cb225e35a5a7B4087Fb8FCB3D18c8c9a58da68e4eDA8A2e';

        $decodedByteArray = CEP57ChecksumUtil::decode($hex);
        $this->assertIsArray($decodedByteArray);
        $this->assertCount(32, $decodedByteArray);
    }
}
