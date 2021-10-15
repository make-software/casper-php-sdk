<?php

namespace Casper\Serializer;

use Casper\Entity\BlockBody;

class BlockBodyJsonSerializer extends JsonSerializer
{
    /**
     * @param BlockBody $blockBody
     */
    public static function toJson($blockBody): array
    {
        return array(
            'proposer' => CLPublicKeyStringSerializer::toHex($blockBody->getProposer()),
            'deploy_hashes' => $blockBody->getDeployHashes(),
            'transfer_hashes' => $blockBody->getTransferHashes(),
        );
    }

    public static function fromJson(array $json): BlockBody
    {
        return new BlockBody(
            CLPublicKeyStringSerializer::fromHex($json['proposer']),
            $json['deploy_hashes'],
            $json['transfer_hashes']
        );
    }
}
