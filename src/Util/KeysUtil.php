<?php

namespace Casper\Util;

class KeysUtil
{
    /**
     * @throws \Exception
     */
    public static function readBase64WithPEM(string $content): array
    {
        $base64 = trim(
            join(
                array_filter(
                    preg_split('/\r?\n/', $content),
                    function (string $string) {
                        return substr($string, 0, 3) !== '---';
                    }
                )
            )
        );

        return ByteUtil::stringToByteArray(base64_decode($base64));
    }
}
