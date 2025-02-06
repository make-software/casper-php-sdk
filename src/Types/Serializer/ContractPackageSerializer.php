<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLURef;
use Casper\Types\ContractPackage;

class ContractPackageSerializer extends JsonSerializer
{
    /**
     * @param ContractPackage $contractPackage
     */
    public static function toJson($contractPackage): array
    {
        return array(
            'access_key' => $contractPackage->getAccessKey()->parsedValue(),
            'versions' => ContractVersionSerializer::toJsonArray($contractPackage->getContractVersions()),
            'disabled_versions' => DisabledVersionSerializer::toJsonArray($contractPackage->getDisabledVersions()),
            'groups' => GroupSerializer::toJsonArray($contractPackage->getGroups()),
        );
    }

    public static function fromJson(array $json): ContractPackage
    {
        return new ContractPackage(
            CLURef::fromString($json['access_key']),
            ContractVersionSerializer::fromJsonArray($json['versions']),
            DisabledVersionSerializer::fromJsonArray($json['disabled_versions']),
            GroupSerializer::fromJsonArray($json['groups'])
        );
    }
}
