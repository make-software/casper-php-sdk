<?php

namespace Tests\Rpc;

use PHPUnit\Framework\TestCase;

use Casper\Entity\Block;
use Casper\Rpc\RpcClient;

class RpcClientTest extends TestCase
{
    protected ?RpcClient $rpcClient;

    protected function setUp(): void
    {
        $nodeUrl = getenv('CASPER_PHP_SDK_TEST_NODE_URL');

        if (!$nodeUrl) {
            throw new \Exception('Please set CASPER_PHP_SDK_TEST_NODE_URL environment variable before test run');
        }

        $this->rpcClient = new RpcClient($nodeUrl);
    }

    protected function tearDown(): void
    {
        $this->rpcClient = null;
    }

    public function testLastApiVersion(): void
    {
        $lastApiVersionBeforeAnyRpcCall = $this->rpcClient->getLastApiVersion();
        $this->assertNull($lastApiVersionBeforeAnyRpcCall);

        $this->rpcClient->getStatus();

        $lastApiVersionAfterSomeRpcCall = $this->rpcClient->getLastApiVersion();
        $this->assertNotNull($lastApiVersionAfterSomeRpcCall);
    }

    public function testGetLatestBlock(): Block
    {
        $latestBlock = $this->rpcClient->getLatestBlock();
        $this->assertInstanceOf(Block::class, $latestBlock);

        return $latestBlock;
    }

    /**
     * @depends testGetLatestBlock
     */
    public function testGetBlockByHash(Block $latestBlock): void
    {
        $block = $this->rpcClient->getBlockByHash($latestBlock->getHash());
        $this->assertEquals($block->getHash(), $latestBlock->getHash());
    }

    /**
     * @depends testGetLatestBlock
     */
    public function testGetBlockByHeight(Block $latestBlock): void
    {
        $block = $this->rpcClient->getBlockByHeight($latestBlock->getHeader()->getHeight());
        $this->assertEquals($block->getHash(), $latestBlock->getHash());
    }
}
