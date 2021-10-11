<?php

namespace Casper\Util;

use Casper\Entity\AsymmetricKey;

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
     * @param array $publicKey
     * @return string
     * @throws \Exception
     */
    public static function accountHex(int $signatureAlgorithm, array $publicKey): string
    {
        if (!in_array($signatureAlgorithm, AsymmetricKey::SUPPORTED_SIGNATURE_ALGORITHM)) {
            throw new \Exception("$signatureAlgorithm invalid signature algorithm");
        }

        return "0$signatureAlgorithm" . ByteUtil::byteArrayToHex($publicKey);
    }
}
