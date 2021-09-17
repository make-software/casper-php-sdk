<?php

namespace Casper\Util;

class ByteUtil
{
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
}
