<?php

namespace Casper\Serializer;

use Casper\Entity\Contract;

class ContractSerializer extends JsonSerializer
{
    /**
     * @param Contract $contractMetadata
     */
    public static function toJson($contractMetadata): array
    {
        return array(
            'contract_package_hash' => $contractMetadata->getContractPackageHash(),
            'contract_wasm_hash' => $contractMetadata->getContractWasmHash(),
            'protocol_version' => $contractMetadata->getProtocolVersion(),
            'entry_points' => EntryPointSerializer::toJsonArray($contractMetadata->getEntryPoints()),
            'named_keys' => $contractMetadata->getNamedKeys(),
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): Contract
    {
        return new Contract(
            $json['contract_package_hash'],
            $json['contract_wasm_hash'],
            $json['protocol_version'],
            EntryPointSerializer::fromJsonArray($json['entry_points']),
            $json['named_keys'],
        );
    }
}
