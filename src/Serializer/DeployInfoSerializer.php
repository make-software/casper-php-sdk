<?php

namespace Casper\Serializer;

use Casper\Entity\DeployInfo;

class DeployInfoSerializer extends JsonSerializer
{
    /**
     * @param DeployInfo $deployInfo
     */
    public static function toJson($deployInfo): array
    {
        return array(
            'deploy_hash' => $deployInfo->getDeployHash(),
            'from' => CLAccountHashSerializer::toString($deployInfo->getFrom()),
            'source' => CLURefSerializer::toString($deployInfo->getSource()),
            'gas' => (string) $deployInfo->getGas(),
            'transfers' => $deployInfo->getTransfers(),
        );
    }

    public static function fromJson(array $json): DeployInfo
    {
        return new DeployInfo(
            $json['deploy_hash'],
            CLAccountHashSerializer::fromString($json['from']),
            CLURefSerializer::fromString($json['source']),
            gmp_init($json['gas']),
            $json['transfers']
        );
    }
}
