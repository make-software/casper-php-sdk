<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\ChainspecBytes;
use Casper\Types\Serializer\ChainspecBytesSerializer;

class InfoGetChainspecResult extends AbstractResult
{
    private ChainspecBytes $chainspecBytes;

    public static function fromJSON($json): self
    {
        return new self($json, ChainspecBytesSerializer::fromJson($json['chainspec_bytes']));
    }

    public function __construct(array $rawJSON, ChainspecBytes $chainspecBytes)
    {
        parent::__construct($rawJSON);
        $this->chainspecBytes = $chainspecBytes;
    }

    public function getChainspecBytes(): ChainspecBytes
    {
        return $this->chainspecBytes;
    }
}
