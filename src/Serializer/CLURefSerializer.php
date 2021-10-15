<?php

namespace Casper\Serializer;

use Casper\CLType\CLURef;
use Casper\Util\ByteUtil;

class CLURefSerializer extends StringSerializer
{
    /**
     * @param CLURef $clUref
     * @return string
     */
    public static function toString($clUref): string
    {
        return $clUref->parsedValue();
    }

    /**
     * @throws \Exception
     */
    public static function fromString(string $uref): CLURef
    {
        $prefix = substr($uref, 0, 5);
        $accessRights = substr($uref, -4);

        if ($prefix !== CLURef::UREF_PREFIX || !preg_match('/-\d{3}$/', $accessRights)) {
            throw new \Exception('Invalid uref string');
        }

        $urefAddressBytes = ByteUtil::hexToByteArray(substr(str_replace(CLURef::UREF_PREFIX, '', $uref), 0, -4));
        $accessRights = (int) str_replace('-', '', $accessRights);

        return new CLURef($urefAddressBytes, $accessRights);
    }
}
