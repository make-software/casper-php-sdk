<?php

namespace Casper\Serializer;

use Casper\Entity\Status;

class StatusSerializer extends JsonSerializer
{
    /**
     * @param Status $status
     */
    public static function toJson($status): array
    {
        return array(
            'chainspec_name' => $status->getChainspecName(),
            'starting_state_root_hash' => $status->getStartingStateRootHash(),
            'last_added_block_info' => BlockInfoSerializer::toJson($status->getLastAddedBlockInfo()),
            'our_public_signing_key' => CLPublicKeySerializer::toHex($status->getOurPublicSigningKey()),
            'round_length' => $status->getRoundLength(),
            'build_version' => $status->getBuildVersion(),
            'next_upgrade' => $status->getNextUpgrade() ? NextUpgradeSerializer::toJson($status->getNextUpgrade()) : null,
            'peers' => PeerSerializer::toJsonArray($status->getPeers()),
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
            BlockInfoSerializer::fromJson($json['last_added_block_info']),
            CLPublicKeySerializer::fromHex($json['our_public_signing_key']),
            $json['round_length'],
            $json['build_version'],
            isset($json['next_upgrade']) ? NextUpgradeSerializer::fromJson($json['next_upgrade']) : null,
            PeerSerializer::fromJsonArray($json['peers'])
        );
    }
}
