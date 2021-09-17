<?php

namespace Casper\Util;

use deemru\Blake2b;

class HashUtil
{
    private static Blake2b $blake2b;

    /**
     * @param int[]
     * @return int[]
     *
     * @throws \Exception
     */
    public static function blake2bHash(array $bytes): array
    {
        if (!isset(self::$blake2b)) {
            self::$blake2b = new Blake2b();
        }

        return ByteUtil::stringToByteArray(
            self::$blake2b->hash(
                ByteUtil::byteArrayToString($bytes)
            )
        );
    }
}
