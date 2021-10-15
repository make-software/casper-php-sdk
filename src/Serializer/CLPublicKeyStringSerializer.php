<?php

namespace Casper\Serializer;

use Casper\Util\ByteUtil;

use Casper\CLType\CLPublicKey;
use Casper\CLType\CLPublicKeyTag;

class CLPublicKeyStringSerializer extends StringSerializer
{
    public static function toHex(CLPublicKey $clPublicKey): string
    {
        return self::toString($clPublicKey);
    }

    /**
     * @throws \Exception
     */
    public static function fromHex(string $hex): CLPublicKey
    {
        return self::fromString($hex);
    }

    /**
     * @param CLPublicKey $clPublicKey
     */
    public static function toString($clPublicKey): string
    {
        return '0'
            . $clPublicKey->tag()->getTagValue()
            . ByteUtil::byteArrayToHex($clPublicKey->value());
    }

    /**
     * @throws \Exception
     */
    public static function fromString(string $string): CLPublicKey
    {
        if (strlen($string) < 2) {
            throw new \Exception('Asymmetric key error: too short');
        }

        $bytes = ByteUtil::hexToByteArray($string);
        $publicKeyTag = $bytes[0];
        $publicKeyBytes = array_slice($bytes, 1);

        return new CLPublicKey($publicKeyBytes, new CLPublicKeyTag($publicKeyTag));
    }
}
