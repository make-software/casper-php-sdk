<?php

namespace Casper\Serializer;

use Casper\Entity\DeployInfo;

class DeployInfoJsonSerializer extends JsonSerializer
{
    /**
     * @param DeployInfo $deployInfo
     */
    public static function toJson($deployInfo): array
    {
        return array(
            'deploy_hash' => $deployInfo->getDeployHash(),
            'from' => CLAccountHashStringSerializer::toString($deployInfo->getFrom()),
            'source' => CLURefStringSerializer::toString($deployInfo->getSource()),
            'gas' => (string) $deployInfo->getGas(),
            'transfers' => $deployInfo->getTransfers(),
        );
    }

    public static function fromJson(array $json): DeployInfo
    {
        return new DeployInfo(
            $json['deploy_hash'],
            CLAccountHashStringSerializer::fromString($json['from']),
            CLURefStringSerializer::fromString($json['source']),
            gmp_init($json['gas']),
            $json['transfers']
        );
    }
}
