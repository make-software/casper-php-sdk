<?php

namespace Casper\Serializer;

use Casper\Util\ByteUtil;
use Casper\Entity\Deploy;

class DeploySerializer extends JsonSerializer
{
    /**
     * @param Deploy $deploy
     */
    public static function toJson($deploy): array
    {
        return [
            'hash' => ByteUtil::byteArrayToHex($deploy->getHash()),
            'header' => DeployHeaderSerializer::toJson($deploy->getHeader()),
            'payment' => DeployExecutableSerializer::toJson($deploy->getPayment()),
            'session' => DeployExecutableSerializer::toJson($deploy->getSession()),
            'approvals' => DeployApprovalSerializer::toJsonArray($deploy->getApprovals())
        ];
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): Deploy
    {
        return new Deploy(
            ByteUtil::hexToByteArray($json['hash']),
            DeployHeaderSerializer::fromJson($json['header']),
            DeployExecutableSerializer::fromJson($json['payment']),
            DeployExecutableSerializer::fromJson($json['session']),
            DeployApprovalSerializer::fromJsonArray($json['approvals'])
        );
    }
}
