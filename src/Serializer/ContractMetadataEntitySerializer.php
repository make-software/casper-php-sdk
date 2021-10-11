<?php

namespace Casper\Serializer;

use Casper\Entity\ContractMetadata;

class ContractMetadataEntitySerializer extends EntitySerializer
{
    /**
     * @param ContractMetadata $contractMetadata
     * @return array
     */
    public static function toJson($contractMetadata): array
    {
        return array(
            'contract_package_hash' => $contractMetadata->getContractPackageHash(),
            'contract_wasm_hash' => $contractMetadata->getContractWasmHash(),
            'protocol_version' => $contractMetadata->getProtocolVersion(),
            'entry_points' => EntryPointEntitySerializer::toJsonArray($contractMetadata->getEntryPoints()),
            'named_keys' => NamedKeyEntitySerializer::toJsonArray($contractMetadata->getNamedKeys()),
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): ContractMetadata
    {
        return new ContractMetadata(
            $json['contract_package_hash'],
            $json['contract_wasm_hash'],
            $json['protocol_version'],
            EntryPointEntitySerializer::fromJsonArray($json['entry_points']),
            NamedKeyEntitySerializer::fromJsonArray($json['named_keys']),
        );
    }
}
