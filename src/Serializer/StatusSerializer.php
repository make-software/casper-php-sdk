<?php

namespace Casper\Serializer;

use Casper\Entity\Status;

class StatusSerializer extends Serializer
{
    /**
     * @param Status $status
     * @return array
     */
    public static function toJson($status): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

    public static function fromJson(array $json): Status
    {
        return new Status(
            $json['chainspec_name'],
            $json['starting_state_root_hash'],
            BlockInfoSerializer::fromJson($json['last_added_block_info']),
            $json['our_public_signing_key'],
            $json['round_length'],
            $json['build_version'],
            $json['next_upgrade'],
            PeerSerializer::fromArray($json['peers'])
        );
    }
}
