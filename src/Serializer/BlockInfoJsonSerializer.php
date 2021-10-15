<?php

namespace Casper\Serializer;

use Casper\Entity\BlockInfo;

class BlockInfoJsonSerializer extends JsonSerializer
{
    /**
     * @param BlockInfo $blockInfo
     */
    public static function toJson($blockInfo): array
    {
        return array(
            'hash' => $blockInfo->getHash(),
            'timestamp' => date('Y-m-d\TH:i:s.u\Z', $blockInfo->getTimestamp()),
            'era_id' => $blockInfo->getEraId(),
            'height' => $blockInfo->getHeight(),
            'state_root_hash' => $blockInfo->getStateRootHash(),
            'creator' => CLPublicKeyStringSerializer::toHex($blockInfo->getCreator()),
        );
    }

    public static function fromJson(array $json): BlockInfo
    {
        return new BlockInfo(
            $json['hash'],
            strtotime($json['timestamp']),
            $json['era_id'],
            $json['height'],
            $json['state_root_hash'],
            CLPublicKeyStringSerializer::fromHex($json['creator'])
        );
    }
}
