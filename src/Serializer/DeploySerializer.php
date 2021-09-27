<?php

namespace Casper\Serializer;

use Casper\Interfaces\Serializer;
use Casper\Util\ByteUtil;
use Casper\Entity\Deploy;

class DeploySerializer implements Serializer
{
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
            DeployApprovalsSerializer::fromJson($json['approvals'])
        );
    }
}
