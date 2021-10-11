<?php

namespace Casper\Serializer;

use Casper\Entity\BlockBody;

class BlockBodyEntitySerializer extends EntitySerializer
{
    /**
     * @param BlockBody $blockBody
     * @return array
     */
    public static function toJson($blockBody): array
    {
        return array(
            'proposer' => $blockBody->getProposer(),
            'deploy_hashes' => $blockBody->getDeployHashes(),
            'transfer_hashes' => $blockBody->getTransferHashes(),
        );
    }

    public static function fromJson(array $json): BlockBody
    {
        return new BlockBody(
            $json['proposer'],
            $json['deploy_hashes'],
            $json['transfer_hashes']
        );
    }
}
