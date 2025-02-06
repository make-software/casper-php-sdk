<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLAccountHash;
use Casper\Types\CLValue\CLURef;
use Casper\Types\DeployInfo;

class DeployInfoSerializer extends JsonSerializer
{
    /**
     * @param DeployInfo $deployInfo
     */
    public static function toJson($deployInfo): array
    {
        return array(
            'deploy_hash' => $deployInfo->getDeployHash(),
            'from' => $deployInfo->getFrom()->parsedValue(),
            'source' => $deployInfo->getSource()->parsedValue(),
            'gas' => (string) $deployInfo->getGas(),
            'transfers' => $deployInfo->getTransfers(),
        );
    }

    public static function fromJson(array $json): DeployInfo
    {
        return new DeployInfo(
            $json['deploy_hash'],
            CLAccountHash::fromString($json['from']),
            CLURef::fromString($json['source']),
            gmp_init($json['gas']),
            $json['transfers']
        );
    }
}
