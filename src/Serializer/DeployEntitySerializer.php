<?php

namespace Casper\Serializer;

use Casper\Util\ByteUtil;
use Casper\Entity\Deploy;

class DeployEntitySerializer extends EntitySerializer
{
    /**
     * @param Deploy $deploy
     * @return array
     */
    public static function toJson($deploy): array
    {
        return [
            'hash' => ByteUtil::byteArrayToHex($deploy->getHash()),
            'header' => DeployHeaderEntitySerializer::toJson($deploy->getHeader()),
            'payment' => DeployExecutableEntitySerializer::toJson($deploy->getPayment()),
            'session' => DeployExecutableEntitySerializer::toJson($deploy->getSession()),
            'approvals' => DeployApprovalEntitySerializer::toJsonArray($deploy->getApprovals())
        ];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): Deploy
    {
        return new Deploy(
            ByteUtil::hexToByteArray($json['hash']),
            DeployHeaderEntitySerializer::fromJson($json['header']),
            DeployExecutableEntitySerializer::fromJson($json['payment']),
            DeployExecutableEntitySerializer::fromJson($json['session']),
            DeployApprovalEntitySerializer::fromJsonArray($json['approvals'])
        );
    }
}
