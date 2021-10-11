<?php

namespace Casper\Serializer;

use Casper\Entity\ContractVersion;

class ContractVersionEntitySerializer extends EntitySerializer
{
    /**
     * @param ContractVersion $contractVersion
     * @return array
     */
    public static function toJson($contractVersion): array
    {
        return array(
            'protocol_version_major' => $contractVersion->getProtocolVersionMajor(),
            'contract_version' => $contractVersion->getContractVersion(),
            'contract_hash' => $contractVersion->getContractHash(),
        );
    }

    public static function fromJson(array $json): ContractVersion
    {
        return new ContractVersion(
            $json['protocol_version_major'],
            $json['contract_version'],
            $json['contract_hash']
        );
    }
}
