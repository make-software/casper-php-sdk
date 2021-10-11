<?php

namespace Casper\Serializer;

use Casper\Entity\ContractPackage;

class ContractPackageEntitySerializer extends EntitySerializer
{
    /**
     * @param ContractPackage $contractPackage
     * @return array
     */
    public static function toJson($contractPackage): array
    {
        return array(
            'access_key' => $contractPackage->getAccessKey(),
            'versions' => ContractVersionEntitySerializer::toJsonArray($contractPackage->getContractVersions()),
            'disabled_versions' => DisabledVersionEntitySerializer::toJsonArray($contractPackage->getDisabledVersions()),
            'groups' => GroupEntitySerializer::toJsonArray($contractPackage->getGroups()),
        );
    }

    public static function fromJson(array $json): ContractPackage
    {
        return new ContractPackage(
            $json['access_key'],
            ContractVersionEntitySerializer::fromJsonArray($json['versions']),
            DisabledVersionEntitySerializer::fromJsonArray($json['disabled_versions']),
            GroupEntitySerializer::fromJsonArray($json['groups'])
        );
    }
}
