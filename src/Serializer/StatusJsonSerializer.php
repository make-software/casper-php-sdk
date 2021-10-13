<?php

namespace Casper\Serializer;

use Casper\Entity\Status;

class StatusJsonSerializer extends JsonSerializer
{
    /**
     * @param Status $status
     */
    public static function toJson($status): array
    {
        return array(
            'chainspec_name' => $status->getChainspecName(),
            'starting_state_root_hash' => $status->getStartingStateRootHash(),
            'last_added_block_info' => BlockInfoJsonSerializer::toJson($status->getLastAddedBlockInfo()),
            'our_public_signing_key' => CLPublicKeyStringSerializer::toString($status->getOurPublicSigningKey()),
            'round_length' => $status->getRoundLength(),
            'build_version' => $status->getBuildVersion(),
            'next_upgrade' => $status->getNextUpgrade(),
            'peers' => PeerJsonSerializer::toJsonArray($status->getPeers()),
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): Status
    {
        return new Status(
            $json['chainspec_name'],
            $json['starting_state_root_hash'],
            BlockInfoJsonSerializer::fromJson($json['last_added_block_info']),
            CLPublicKeyStringSerializer::fromString($json['our_public_signing_key']),
            $json['round_length'],
            $json['build_version'],
            $json['next_upgrade'],
            PeerJsonSerializer::fromJsonArray($json['peers'])
        );
    }
}
