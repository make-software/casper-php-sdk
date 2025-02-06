<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLAccountHash;
use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\InitiatorAddr;

class InitiatorAddrSerializer extends JsonSerializer
{
    /**
     * @param InitiatorAddr $initiatorAddr
     * @throws \Exception
     */
    public static function toJson($initiatorAddr): array
    {
        if ($initiatorAddr->getPublicKey()) {
            return array(
                'PublicKey' => $initiatorAddr->getPublicKey()->toHex(),
            );
        }
        else if ($initiatorAddr->getAccountHash()) {
            return array(
                'AccountHash' => $initiatorAddr->getAccountHash()->parsedValue()
            );
        }

        throw new \Exception('Unknown InitiatorAddr type');
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): InitiatorAddr
    {
        return new InitiatorAddr(
            $json['PublicKey'] ? CLPublicKey::fromHex($json['PublicKey']) : null,
            $json['AccountHash'] ? CLAccountHash::fromString($json['AccountHash']) : null
        );
    }
}
