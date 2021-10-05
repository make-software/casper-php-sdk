<?php

namespace Casper\Serializer;

use Casper\Util\ByteUtil;

use Casper\CLType\CLPublicKey;
use Casper\Entity\DeployHeader;

class DeployHeaderSerializer extends Serializer
{
    const MS_IN_SEC = 1000;
    const MS_IN_MIN = 60000;
    const MS_IN_HOUR = 3600000;
    const MS_IN_DAY = 86400000;

    /**
     * @param DeployHeader $header
     * @return array
     */
    public static function toJson($header): array
    {
        return [
            'account' => $header->getPublicKey()->toHex(),
            'body_hash' => ByteUtil::byteArrayToHex($header->getBodyHash()),
            'chain_name' => $header->getChainName(),
            'dependencies' => $header->getDependencies(),
            'gas_price' => $header->getGasPrice(),
            'timestamp' => date('Y-m-d\TH:i:s.u\Z', $header->getTimestamp()),
            'ttl' => self::ttlToString($header->getTtl()),
        ];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): DeployHeader
    {
        return new DeployHeader(
            CLPublicKey::fromHex($json['account']),
            strtotime($json['timestamp']),
            self::ttlToInt($json['ttl']),
            (int) $json['gas_price'],
            ByteUtil::hexToByteArray($json['body_hash']),
            [],
            $json['chain_name']
        );
    }

    private static function ttlToString(int $ttl): string
    {
        if ($ttl < self::MS_IN_SEC) {
            return $ttl . 'ms';
        }
        elseif ($ttl < self::MS_IN_MIN) {
            return (int) ($ttl / self::MS_IN_SEC) . 's';
        }
        elseif ($ttl < self::MS_IN_HOUR) {
            return (int) ($ttl / self::MS_IN_MIN) . 'm';
        }
        elseif ($ttl < self::MS_IN_DAY) {
            return (int) ($ttl / self::MS_IN_HOUR) . 'h';
        }
        else {
            return (int) ($ttl / self::MS_IN_DAY) . 'day';
        }
    }

    /**
     * @throws \Exception
     */
    protected static function ttlToInt(string $ttl): int
    {
        if (strpos($ttl, 'ms')) {
            return (int) $ttl;
        }
        elseif (strpos($ttl, 's')) {
            return (int) $ttl * self::MS_IN_SEC;
        }
        elseif (strpos($ttl, 'm')) {
            return (int) $ttl * self::MS_IN_MIN;
        }
        elseif (strpos($ttl, 'h')) {
            return (int) $ttl * self::MS_IN_HOUR;
        }
        elseif (strpos($ttl, 'day')) {
            return (int) $ttl * self::MS_IN_DAY;
        }

        throw new \Exception('Unsupported TTL unit');
    }
}
