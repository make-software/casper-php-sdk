<?php

namespace Casper\Util;

class CEP57ChecksumUtil
{
    private const HEX_CHARS = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];

    /**
     * @param string $hex
     * @return bool
     *
     * @throws \Exception
     */
    public static function hasChecksum(string $hex): bool
    {
        $mix = 0;

        foreach (str_split($hex) as $char) {
            if ($char >= '0' && $char <= '9') {
                $mix |= 0x00;
            }
            elseif ($char >= 'a' && $char <= 'f') {
                $mix |= 0x01;
            }
            elseif ($char >= 'A' && $char <= 'F') {
                $mix |= 0x02;
            }
            else {
                throw new \Exception('Input is not an hexadecimal string');
            }
        }

        return $mix > 2;
    }

    /**
     * @param array $bytes
     * @return string
     *
     * @throws \Exception
     */
    public static function encode(array $bytes): string
    {
        $nibbles = self::byteToNibbles($bytes);
        $hashBits = self::bytesToBitsCycle(HashUtil::blake2bHash($bytes));

        $bitIndex = 0;
        foreach ($nibbles as $nibble) {
            $char = self::HEX_CHARS[$nibble];
            $result[] = ($char >= 'a' && $char <= 'f') && $hashBits[$bitIndex++]
                ? strtoupper($char)
                : $char;
        }

        return implode($result ?? []);
    }

    /**
     * @param string $hex
     * @return array
     *
     * @throws \Exception
     */
    public static function decode(string $hex): array
    {
        $bytes = ByteUtil::hexToByteArray($hex);

        if (!self::hasChecksum($hex)) {
            return $bytes;
        }

        $encoded = self::encode($bytes);

        if ($encoded !== $hex) {
            throw new \Exception('Invalid checksum');
        }

        return $bytes;
    }

    /**
     * @param array $bytes
     * @return int[]
     *
     * @throws \Exception
     */
    private static function byteToNibbles(array $bytes): array
    {
        foreach ($bytes as $byte) {
            $nibbles[] = $byte >> 4;
            $nibbles[] = $byte & 0x0F;
        }

        return $nibbles;
    }

    /**
     * @param array $bytes
     * @return int[]
     */
    private static function bytesToBitsCycle(array $bytes): array
    {
        for ($i = 0; $i < count($bytes); $i++) {
            for ($j = 0; $j < 8; $j++) {
                $bits[] = ($bytes[$i] >> $j) & 0x01;
            }
        }

        return $bits;
    }
}
