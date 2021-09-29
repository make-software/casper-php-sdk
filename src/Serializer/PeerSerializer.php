<?php

namespace Casper\Serializer;

use Casper\Entity\Peer;

class PeerSerializer extends Serializer
{
    /**
     * @param Peer $peer
     * @return array
     */
    public static function toJson($peer): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): Peer
    {
        return new Peer($json['node_id'], $json['address']);
    }
}
