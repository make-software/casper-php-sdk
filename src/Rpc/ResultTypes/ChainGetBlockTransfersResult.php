<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\Serializer\TransferSerializer;

class ChainGetBlockTransfersResult extends AbstractResult
{
    private array $transfers;

    public static function fromJSON(array $json): self
    {
        return new self($json, TransferSerializer::fromJsonArray($json['transfers']));
    }

    public function __construct(array $rawJSON, array $transfers)
    {
        parent::__construct($rawJSON);
        $this->transfers = $transfers;
    }

    public function getTransfers(): array
    {
        return $this->transfers;
    }
}
