<?php

namespace Casper\Serializer;

use Casper\Entity\DeployInfo;

class DeployInfoEntitySerializer extends EntitySerializer
{
    /**
     * @param DeployInfo $deployInfo
     * @return array
     */
    public static function toJson($deployInfo): array
    {
        return array(
            'deploy_hash' => $deployInfo->getDeployHash(),
            'from' => $deployInfo->getFrom(),
            'source' => $deployInfo->getSource(),
            'gas' => $deployInfo->getGas(),
            'transfers' => $deployInfo->getTransfers(),
        );
    }

    public static function fromJson(array $json): DeployInfo
    {
        return new DeployInfo(
            $json['deploy_hash'],
            $json['from'],
            $json['source'],
            $json['gas'],
            $json['transfers']
        );
    }
}
