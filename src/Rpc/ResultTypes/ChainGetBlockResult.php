<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\Block;

class ChainGetBlockResult extends AbstractResult
{
    private Block $block;

    /**
     * @throws \Exception
     */
    public static function fromChainGetBlockResultV1Compatible(
        ChainGetBlockResultV1Compatible $chainGetBlockResultV1Compatible
    ): self
    {
        if ($chainGetBlockResultV1Compatible->getBlockWithSignatures() !== null) {
            $block = Block::newBlockFromBlockWrapper(
                $chainGetBlockResultV1Compatible->getBlockWithSignatures()->getBlock(),
                $chainGetBlockResultV1Compatible->getBlockWithSignatures()->getProofs()
            );
        }
        else if ($chainGetBlockResultV1Compatible->getBlockV1() !== null) {
            $block = Block::newBlockFromBlockV1($chainGetBlockResultV1Compatible->getBlockV1());
        }
        else {
            throw new \Exception('Incorrect RPC response structure');
        }

        return new self(
            $chainGetBlockResultV1Compatible->getRawJSON(),
            $block
        );
    }

    public function __construct(array $rawJSON, Block $block)
    {
        parent::__construct($rawJSON);
        $this->block = $block;
    }

    public function getBlock(): Block
    {
        return $this->block;
    }
}
