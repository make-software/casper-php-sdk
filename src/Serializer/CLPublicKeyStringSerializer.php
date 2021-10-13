<?php

namespace Casper\Serializer;

use Casper\CLType\CLPublicKey;
use Casper\CLType\CLPublicKeyTag;
use Casper\Util\ByteUtil;

class CLPublicKeyStringSerializer extends StringSerializer
{
    /**
     * @param CLPublicKey $clPublicKey
     * @return string
     */
    public static function toString($clPublicKey): string
    {
        return $clPublicKey->toHex();
    }

    /**
     * @throws \Exception
     */
    public static function fromString(string $hex): CLPublicKey
    {
        if (strlen($hex) < 2) {
            throw new \Exception('Asymmetric key error: too short');
        }

        $bytes = ByteUtil::hexToByteArray($hex);
        $publicKeyTag = $bytes[0];
        $publicKeyBytes = array_slice($bytes, 1);

        return new CLPublicKey($publicKeyBytes, new CLPublicKeyTag($publicKeyTag));
    }
}
