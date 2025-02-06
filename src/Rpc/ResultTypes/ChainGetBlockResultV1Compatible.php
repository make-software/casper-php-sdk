<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\BlockV1;
use Casper\Types\BlockWithSignatures;
use Casper\Types\Serializer\BlockV1Serializer;
use Casper\Types\Serializer\BlockWithSignaturesSerializer;

class ChainGetBlockResultV1Compatible extends AbstractResult
{
    private ?BlockWithSignatures $blockWithSignatures;

    private ?BlockV1 $blockV1;

    public static function fromJSON(array $json): self
    {
        return new self(
            $json,
            isset($json['block_with_signatures'])
                ? BlockWithSignaturesSerializer::fromJson($json['block_with_signatures'])
                : null,
            isset($json['block'])
                ? BlockV1Serializer::fromJson($json['block'])
                : null
        );
    }

    public function __construct(array $rawJSON, ?BlockWithSignatures $blockWithSignatures, ?BlockV1 $blockV1)
    {
        parent::__construct($rawJSON);
        $this->blockWithSignatures = $blockWithSignatures;
        $this->blockV1 = $blockV1;
    }

    public function getBlockWithSignatures(): ?BlockWithSignatures
    {
        return $this->blockWithSignatures;
    }

    public function getBlockV1(): ?BlockV1
    {
        return $this->blockV1;
    }
}
