<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\AuctionState;
use Casper\Types\Serializer\AuctionStateSerializer;

class StateGetAuctionInfoResult extends AbstractResult
{
    private AuctionState $auctionState;

    public static function fromJSON(array $json): self
    {
        return new self($json, AuctionStateSerializer::fromJSON($json['auction_state']));
    }

    public function __construct(array $rawJSON, AuctionState $auctionState)
    {
        parent::__construct($rawJSON);
        $this->auctionState = $auctionState;
    }

    public function getAuctionState(): AuctionState
    {
        return $this->auctionState;
    }
}
