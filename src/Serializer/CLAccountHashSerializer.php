<?php

namespace Casper\Serializer;

use Casper\CLType\CLAccountHash;
use Casper\Util\ByteUtil;

class CLAccountHashSerializer extends StringSerializer
{
    /**
     * @param CLAccountHash $clAccountHash
     * @return string
     */
    public static function toString($clAccountHash): string
    {
        return $clAccountHash->parsedValue();
    }

    /**
     * @throws \Exception
     */
    public static function fromString(string $accountHashString): CLAccountHash
    {
        $prefix = substr($accountHashString, 0, 13);

        if ($prefix !== CLAccountHash::ACCOUNT_HASH_PREFIX) {
            throw new \Exception('Invalid account hash string');
        }

        return new CLAccountHash(
            ByteUtil::hexToByteArray(str_replace(CLAccountHash::ACCOUNT_HASH_PREFIX, '', $accountHashString))
        );
    }
}
