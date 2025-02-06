<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\BlockHeader;
use Casper\Types\Serializer\BlockHeaderV1Serializer;
use Casper\Types\Serializer\BlockHeaderV2Serializer;
use Casper\Types\Serializer\StoredValueSerializer;
use Casper\Types\StoredValue;

class QueryGlobalStateResult extends AbstractResult
{
    private ?BlockHeader $blockHeader;

    private StoredValue $storedValue;

    private string $merkleProof;

    public static function fromJSON(array $json): self
    {
        $blockHeader = null;
        if (isset($json['block_header'])) {
            $blockHeader = isset($json['block_header']['Version2'])
                ? BlockHeader::newBlockHeaderFromV2(BlockHeaderV2Serializer::fromJson($json['block_header']['Version2']))
                : BlockHeader::newBlockHeaderFromV1(BlockHeaderV1Serializer::fromJson($json['block_header']['Version1']));
        }

        return new self(
            $json,
            $blockHeader,
            StoredValueSerializer::fromJson($json['stored_value']),
            $json['merkle_proof']
        );
    }

    public function __construct(
        array $rawJSON,
        ?BlockHeader $blockHeader,
        StoredValue $storedValue,
        string $merkleProof
    )
    {
        parent::__construct($rawJSON);
        $this->blockHeader = $blockHeader;
        $this->storedValue = $storedValue;
        $this->merkleProof = $merkleProof;
    }

    public function getBlockHeader(): ?BlockHeader
    {
        return $this->blockHeader;
    }

    public function getStoredValue(): StoredValue
    {
        return $this->storedValue;
    }

    public function getMerkleProof(): string
    {
        return $this->merkleProof;
    }
}
