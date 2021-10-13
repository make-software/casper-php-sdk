<?php

namespace Casper\Serializer;

use Casper\Util\ByteUtil;
use Casper\Entity\Deploy;

class DeployJsonSerializer extends JsonSerializer
{
    /**
     * @param Deploy $deploy
     */
    public static function toJson($deploy): array
    {
        return [
            'hash' => ByteUtil::byteArrayToHex($deploy->getHash()),
            'header' => DeployHeaderJsonSerializer::toJson($deploy->getHeader()),
            'payment' => DeployExecutableJsonSerializer::toJson($deploy->getPayment()),
            'session' => DeployExecutableJsonSerializer::toJson($deploy->getSession()),
            'approvals' => DeployApprovalJsonSerializer::toJsonArray($deploy->getApprovals())
        ];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): Deploy
    {
        return new Deploy(
            ByteUtil::hexToByteArray($json['hash']),
            DeployHeaderJsonSerializer::fromJson($json['header']),
            DeployExecutableJsonSerializer::fromJson($json['payment']),
            DeployExecutableJsonSerializer::fromJson($json['session']),
            DeployApprovalJsonSerializer::fromJsonArray($json['approvals'])
        );
    }
}
