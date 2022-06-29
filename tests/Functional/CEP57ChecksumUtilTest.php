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
        $hexWithCheckSum = 'de8649985929090b7CB225e35a5A7B4087fb8fcB3D18C8C9a58DA68e4edA8a2E';
        $this->assertTrue(CEP57ChecksumUtil::hasChecksum($hexWithCheckSum));

        $hexWithoutCheckSum = 'de8649985929090b7cb225e35a5a7b4087fb8fcb3d18c8c9a58da68e4eda8a2e';
        $this->assertFalse(CEP57ChecksumUtil::hasChecksum($hexWithoutCheckSum));
    }

    /**
     * @throws \Exception
     */
    public function testEncode(): void
    {
        $hex = 'de8649985929090b7CB225e35a5A7B4087fb8fcB3D18C8C9a58DA68e4edA8a2E';
        $bytes = ByteUtil::hexToByteArray($hex);

        $encodedHex = CEP57ChecksumUtil::encode($bytes);
        $this->assertEquals($hex, $encodedHex);
    }

    /**
     * @throws \Exception
     */
    public function testDecode(): void
    {
        $hex = 'de8649985929090b7CB225e35a5A7B4087fb8fcB3D18C8C9a58DA68e4edA8a2E';

        $decodedByteArray = CEP57ChecksumUtil::decode($hex);
        $this->assertIsArray($decodedByteArray);
        $this->assertCount(32, $decodedByteArray);
    }
}
