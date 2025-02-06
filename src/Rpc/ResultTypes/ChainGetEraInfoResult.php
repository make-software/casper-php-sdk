<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\EraSummary;
use Casper\Types\Serializer\EraSummarySerializer;

class ChainGetEraInfoResult extends AbstractResult
{
    private ?EraSummary $eraSummary;

    public static function fromJSON(array $json): self
    {
        return new self($json, isset($json['era_summary']) ? EraSummarySerializer::fromJson($json['era_summary']) : null);
    }

    public function __construct(array $rawJSON, ?EraSummary $eraSummary)
    {
        parent::__construct($rawJSON);
        $this->eraSummary = $eraSummary;
    }

    public function getEraSummary(): ?EraSummary
    {
        return $this->eraSummary;
    }
}
