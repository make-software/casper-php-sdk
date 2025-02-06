<?php

namespace Casper\Util;

class HashUtil
{
    /**
     * @throws \SodiumException
     * @throws \Exception
     */
    public static function blake2bHash(array $bytes, int $length = 32): array
    {
        $hashState = sodium_crypto_generichash_init('', $length);
        sodium_crypto_generichash_update($hashState, ByteUtil::byteArrayToString($bytes));

        return ByteUtil::stringToByteArray(
            sodium_crypto_generichash_final($hashState, $length)
        );
    }
}
