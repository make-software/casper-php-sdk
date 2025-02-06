<?php

namespace Casper\Types\Serializer;

use Casper\Types\BlockBodyV1;
use Casper\Types\CLValue\CLPublicKey;

class BlockBodyV1Serializer extends JsonSerializer
{
    /**
     * @param BlockBodyV1 $blockBodyV1
     */
    public static function toJson($blockBodyV1): array
    {
        return array(
            'proposer' => $blockBodyV1->getProposer()->toHex(),
            'deploy_hashes' => $blockBodyV1->getDeployHashes(),
            'transfer_hashes' => $blockBodyV1->getTransferHashes(),
        );
    }

    public static function fromJson(array $json): BlockBodyV1
    {
        return new BlockBodyV1(
            CLPublicKey::fromHex($json['proposer']),
            $json['deploy_hashes'],
            $json['transfer_hashes']
        );
    }
}
