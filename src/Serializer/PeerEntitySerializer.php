<?php

namespace Casper\Serializer;

use Casper\Entity\Peer;

class PeerEntitySerializer extends EntitySerializer
{
    /**
     * @param Peer $peer
     * @return array
     */
    public static function toJson($peer): array
    {
        return array(
            'node_id' => $peer->getNodeId(),
            'address' => $peer->getAddress(),
        );
    }

    public static function fromJson(array $json): Peer
    {
        return new Peer(
            $json['node_id'],
            $json['address']
        );
    }
}
