<?php

namespace Casper\Entity;

class Peer
{
    private string $nodeId;

    private string $address;

    public function __construct(string $nodeId, string $address)
    {
        $this->nodeId = $nodeId;
        $this->address = $address;
    }

    public function getNodeId(): string
    {
        return $this->nodeId;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}
