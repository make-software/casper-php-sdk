<?php

namespace Casper\Types;

class BlockV2
{
    private string $hash; // Hash

    private BlockHeaderV2 $header;

    private BlockBodyV2 $body;

    // $hash can be string or Hash
    public function __construct(string $hash, BlockHeaderV2 $header, BlockBodyV2 $body)
    {
        $this->hash = $hash;
        $this->header = $header;
        $this->body = $body;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getHeader(): BlockHeaderV2
    {
        return $this->header;
    }

    public function getBody(): BlockBodyV2
    {
        return $this->body;
    }
}
