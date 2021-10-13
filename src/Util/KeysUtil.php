<?php

namespace Casper\Util;

use Casper\Util\Crypto\AsymmetricKey;

class KeysUtil
{
    /**
     * @throws \Exception
     */
    public static function readBase64WithPEM(string $content): string
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

        return base64_decode($base64);
    }

    /**
     * @param int $signatureAlgorithm
     * @param string $hexPublicKey
     * @return string
     * @throws \Exception
     */
    public static function accountHex(int $signatureAlgorithm, string $hexPublicKey): string
    {
        if (!in_array($signatureAlgorithm, AsymmetricKey::SUPPORTED_SIGNATURE_ALGORITHM)) {
            throw new \Exception("$signatureAlgorithm invalid signature algorithm");
        }

        return "0" . $signatureAlgorithm . $hexPublicKey;
    }
}
