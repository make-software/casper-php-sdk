<?php

namespace Casper\Serializer;

use Casper\Entity\Block;
use Casper\Entity\BlockBody;
use Casper\Entity\BlockHeader;
use Casper\Entity\BlockProof;

class BlockSerializer extends Serializer
{
    public static function fromJson(array $json): Block
    {
        $header = new BlockHeader(
            $json['header']['parent_hash'],
            $json['header']['state_root_hash'],
            $json['header']['body_hash'],
            $json['header']['random_bit'],
            $json['header']['accumulated_seed'],
            $json['header']['era_end'],
            strtotime($json['header']['timestamp']),
            $json['header']['era_id'],
            $json['header']['height'],
            $json['header']['protocol_version'],
        );
        $body = new BlockBody(
            $json['body']['proposer'],
            $json['body']['deploy_hashes'],
            $json['body']['transfer_hashes']
        );
        $proofs = array_map(
            function($json) {
                return new BlockProof($json['public_key'], $json['signature']);
            },
            $json['proofs']
        );

        return new Block($json['hash'], $header, $body, $proofs);
    }

    public static function toJson($object): array
    {
        // TODO: Implement toJson() method.
        return [];
    }
}
