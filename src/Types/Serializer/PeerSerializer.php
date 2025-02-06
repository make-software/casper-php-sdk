<?php

namespace Casper\Types\Serializer;

use Casper\Types\Peer;

class PeerSerializer extends JsonSerializer
{
    /**
     * @param Peer $peer
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
