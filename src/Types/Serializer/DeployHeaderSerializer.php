<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Util\ByteUtil;
use Casper\Util\DateTimeUtil;

use Casper\Types\DeployHeader;

class DeployHeaderSerializer extends JsonSerializer
{
    /**
     * @param DeployHeader $header
     */
    public static function toJson($header): array
    {
        return [
            'account' => $header->getPublicKey()->toHex(),
            'body_hash' => ByteUtil::byteArrayToHex($header->getBodyHash()),
            'chain_name' => $header->getChainName(),
            'dependencies' => $header->getDependencies(),
            'gas_price' => $header->getGasPrice(),
            'timestamp' => DateTimeUtil::getFormattedDateFromTimestampMs($header->getTimestamp()),
            'ttl' => DateTimeUtil::ttlToString($header->getTtl()),
        ];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): DeployHeader
    {
        return new DeployHeader(
            CLPublicKey::fromHex($json['account']),
            DateTimeUtil::getTimestampMsFromDateString($json['timestamp']),
            DateTimeUtil::ttlToInt($json['ttl']),
            (int) $json['gas_price'],
            ByteUtil::hexToByteArray($json['body_hash']),
            [],
            $json['chain_name']
        );
    }
}
