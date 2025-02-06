<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\MinimalBlockInfo;
use Casper\Util\DateTimeUtil;

class MinimalBlockInfoSerializer extends JsonSerializer
{
    /**
     * @param MinimalBlockInfo $minimalBlockInfo
     */
    public static function toJson($minimalBlockInfo): array
    {
        return array(
            'hash' => $minimalBlockInfo->getHash(),
            'timestamp' => DateTimeUtil::getFormattedDateFromTimestampMs($minimalBlockInfo->getTimestamp()),
            'era_id' => $minimalBlockInfo->getEraId(),
            'height' => $minimalBlockInfo->getHeight(),
            'state_root_hash' => $minimalBlockInfo->getStateRootHash(),
            'creator' => $minimalBlockInfo->getCreator()->toHex(),
        );
    }

    public static function fromJson(array $json): MinimalBlockInfo
    {
        return new MinimalBlockInfo(
            $json['hash'],
            DateTimeUtil::getTimestampMsFromDateString($json['timestamp']),
            $json['era_id'],
            $json['height'],
            $json['state_root_hash'],
            CLPublicKey::fromHex($json['creator'])
        );
    }
}
