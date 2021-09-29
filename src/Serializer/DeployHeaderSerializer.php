<?php

namespace Casper\Serializer;

use Casper\CLType\CLPublicKey;
use Casper\Entity\DeployHeader;
use Casper\Util\ByteUtil;

class DeployHeaderSerializer extends Serializer
{
    /**
     * @param DeployHeader $header
     * @return array
     */
    public static function toJson($header): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): DeployHeader
    {
        return new DeployHeader(
            CLPublicKey::fromHex($json['account']),
            strtotime($json['timestamp']),
            self::deserializeTtl($json['ttl']),
            (int) $json['gas_price'],
            ByteUtil::hexToByteArray($json['body_hash']),
            [],
            $json['chain_name']
        );
    }

    /**
     * @throws \Exception
     */
    protected static function deserializeTtl(string $ttl): int
    {
        if (strpos($ttl, 'ms')) {
            return (int) $ttl;
        }
        elseif (strpos($ttl, 's')) {
            return (int) $ttl * 1000;
        }
        elseif (strpos($ttl, 'm')) {
            return (int) $ttl * 60 * 1000;
        }
        elseif (strpos($ttl, 'h')) {
            return (int) $ttl * 60 * 60 * 1000;
        }
        elseif (strpos($ttl, 'day')) {
            return (int) $ttl * 24 * 60 * 60 * 1000;
        }

        throw new \Exception('Unsupported TTL unit');
    }
}
