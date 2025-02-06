<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\Peer;
use Casper\Types\Serializer\PeerSerializer;

class InfoGetPeerResult extends AbstractResult
{
    /**
     * @var Peer[]
     */
    private array $peers;

    public static function fromJSON(array $json): self
    {
        return new self($json, PeerSerializer::fromJsonArray($json['peers']));
    }

    public function __construct(array $rawJSON, array $peers)
    {
        parent::__construct($rawJSON);
        $this->peers = $peers;
    }

    public function getPeers(): array
    {
        return $this->peers;
    }
}
