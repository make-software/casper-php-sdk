<?php

namespace Casper\Util;

use Casper\Interfaces\ToBytesInterface;

class ByteUtil
{
    public static function isByteArray(array $bytes): bool
    {
        foreach ($bytes as $byte) {
            if (!is_int($byte) || $byte < 0 || $byte > 255) {
                return false;
            }
        }

        return true;
    }

    /**
     * @throws \Exception
     */
    public static function stringToByteArray(string $string): array
    {
        $byteArray = unpack('C*', $string);

        if ($byteArray === false) {
            throw new \Exception("Can't convert $string to byte array");
        }

        return $byteArray;
    }

    public static function byteArrayToString(array $byteArray): string
    {
        return join(array_map("chr", $byteArray));
    }

    public static function byteArrayToHex(array $byteArray): string
    {
        return bin2hex(join(array_map("chr", $byteArray)));
    }

    /**
     * @throws \Exception
     */
    public static function hexToByteArray(string $hexString): array
    {
        $string = hex2bin($hexString);

        if ($string === false) {
            throw new \Exception("Can't convert $hexString to string");
        }

        $byteArray = unpack('C*', $string);

        if ($byteArray === false) {
            throw new \Exception("Can't convert $hexString to byte array");
        }

        return $byteArray;
    }

    public static function stringToHex(string $string): string
    {
        return bin2hex($string);
    }

    /**
     * @param string $string
     * @return int[]
     * @throws \Exception
     */
    public static function stringToBytesU32(string $string): array
    {
        $bytes = self::stringToByteArray($string);
        return array_merge(self::toBytesU32(count($bytes)), $bytes);
    }

    /**
     * @param ToBytesInterface[] $vector
     * @return array
     * @throws \Exception
     */
    public static function vectorToBytesU32(array $vector): array
    {
        $convertedVector = [];
        $result = [];

        foreach ($vector as $element) {
            $convertedVector[] = $element->toBytes();
        }

        array_unshift($convertedVector, self::toBytesU32(count($vector)));

        foreach ($convertedVector as $element) {
            $result = array_merge($result, $element);
        }

        return $result;
    }

    /**
     * @param int[] $arr
     * @return int[]
     * @throws \Exception
     */
    public static function toBytesArrayU8(array $arr): array
    {
        return array_merge(self::toBytesU32(count($arr)), $arr);
    }

    /**
     * Converts `u32` to little endian.
     * @param int|string $value
     * @return int[]
     * @throws \Exception
     */
    public static function toBytesU32($value): array
    {
        return self::toBytesNumber(32, false, $value);
    }

    /**
     * Converts `u64` to little endian.
     * @param int|string $value
     * @return int[]
     * @throws \Exception
     */
    public static function toBytesU64($value): array
    {
        return self::toBytesNumber(64, false, $value);
    }

    /**
     * @param int $bitSize
     * @param bool $signed
     * @param int|string|\GMP $value
     * @return int[]
     *
     * @throws \Exception
     */
    public static function toBytesNumber(int $bitSize, bool $signed, $value): array
    {
        $bnValue = $value instanceof \GMP
            ? $value
            : gmp_init($value);

        if (!$bnValue instanceof \GMP) {
            throw new \Exception("Unable to convert variable to GMP. Invalid value: $value");
        }

        $maxUIntValue = gmp_pow(2, $bitSize) - 1;

        if ($signed) {
            $bounds = gmp_pow(2, $bitSize - 1) - 1;

            // If $bnValue greater than $bounds or $bnValue less than ($bounds + 1) * -1
            if (gmp_cmp($bnValue, $bounds) === 1 || gmp_cmp(($bounds + 1) * -1, $bnValue) === 1) {
                throw new \Exception("Value out-of-bounds, value: $bnValue");
            }
        }
        elseif (gmp_cmp(0, $bnValue) === 1 || gmp_cmp($bnValue, $maxUIntValue) === 1) {
            throw new \Exception("Value out-of-bounds, value: $bnValue");
        }

        // Bit mask
        $bnValue = gmp_and($bnValue, $maxUIntValue);
        $bytes = ByteUtil::stringToByteArray(gmp_export($bnValue));

        if (gmp_cmp($bnValue, 0) !== -1) {
            // for positive number, we had to deal with paddings
            if ($bitSize > 64) {
                // for u128, u256, u512, we have to and append extra byte for length
                return array_reverse(
                    array_merge($bytes, [count($bytes)])
                );
            }
            else {
                // for other types, we have to add padding 0s
                $byteLength = $bitSize / 8;

                return array_merge(
                    array_reverse($bytes),
                    array_fill(0, $byteLength - count($bytes), 0)
                );
            }
        }
        else {
            return array_reverse($bytes);
        }
    }
}
