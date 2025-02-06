<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\Status;

class StatusSerializer extends JsonSerializer
{
    /**
     * @param Status $status
     */
    public static function toJson($status): array
    {
        return array(
            'api_version' => $status->getApiVersion(),
            'chainspec_name' => $status->getChainspecName(),
            'starting_state_root_hash' => $status->getStartingStateRootHash(),
            'last_added_block_info' => MinimalBlockInfoSerializer::toJson($status->getLastAddedBlockInfo()),
            'our_public_signing_key' => $status->getOurPublicSigningKey()->toHex(),
            'round_length' => $status->getRoundLength(),
            'build_version' => $status->getBuildVersion(),
            'next_upgrade' => $status->getNextUpgrade() ? NextUpgradeSerializer::toJson($status->getNextUpgrade()) : null,
            'peers' => PeerSerializer::toJsonArray($status->getPeers()),
            'uptime' => $status->getUptime(),
            'reactor_state' => $status->getReactorState(),
            'last_progress' => $status->getLastProgress()->format('Y-m-d\TH:i:s.v\Z'),
            'available_block_range' => BlockRangeSerializer::toJson($status->getAvailableBlockRange()),
        );
    }

    /**
     * @throws \Exception
     */
    public static function fromJson(array $json): Status
    {
        return new Status(
            $json['api_version'],
            $json['chainspec_name'],
            $json['starting_state_root_hash'],
            MinimalBlockInfoSerializer::fromJson($json['last_added_block_info']),
            CLPublicKey::fromHex($json['our_public_signing_key']),
            $json['round_length'],
            $json['build_version'],
            isset($json['next_upgrade']) ? NextUpgradeSerializer::fromJson($json['next_upgrade']) : null,
            PeerSerializer::fromJsonArray($json['peers']),
            $json['uptime'],
            $json['reactor_state'],
            new \DateTime($json['last_progress']),
            BlockRangeSerializer::fromJson($json['available_block_range'])
        );
    }
}
