<?php

namespace Casper\Serializer;

use Casper\Entity\ContractPackage;

class ContractPackageJsonSerializer extends JsonSerializer
{
    /**
     * @param ContractPackage $contractPackage
     */
    public static function toJson($contractPackage): array
    {
        return array(
            'access_key' => CLURefStringSerializer::toString($contractPackage->getAccessKey()),
            'versions' => ContractVersionJsonSerializer::toJsonArray($contractPackage->getContractVersions()),
            'disabled_versions' => DisabledVersionJsonSerializer::toJsonArray($contractPackage->getDisabledVersions()),
            'groups' => GroupJsonSerializer::toJsonArray($contractPackage->getGroups()),
        );
    }

    public static function fromJson(array $json): ContractPackage
    {
        return new ContractPackage(
            CLURefStringSerializer::fromString($json['access_key']),
            ContractVersionJsonSerializer::fromJsonArray($json['versions']),
            DisabledVersionJsonSerializer::fromJsonArray($json['disabled_versions']),
            GroupJsonSerializer::fromJsonArray($json['groups'])
        );
    }
}
