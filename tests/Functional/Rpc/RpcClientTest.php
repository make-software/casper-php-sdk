<?php

namespace Tests\Functional\Rpc;

use PHPUnit\Framework\TestCase;

use Casper\Serializer\CLPublicKeySerializer;
use Casper\Util\ByteUtil;

use Casper\Rpc\RpcClient;
use Casper\Rpc\RpcError;

use Casper\Entity\Account;
use Casper\Entity\BlockBody;
use Casper\Entity\BlockHeader;
use Casper\Entity\Block;

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

    public function testGetLastApiVersion(): void
    {
        $lastApiVersionBeforeAnyRpcCall = $this->rpcClient->getLastApiVersion();
        $this->assertNull($lastApiVersionBeforeAnyRpcCall);

        $this->rpcClient->getStatus();

        $lastApiVersionAfterSomeRpcCall = $this->rpcClient->getLastApiVersion();
        $this->assertNotNull($lastApiVersionAfterSomeRpcCall);
    }

    public function testGetDeploy(): void
    {
        $deployHashFromTheTestnet = '7ab7208819bead36b7143757c3d4b7d0d749e5fd2e49b7ae58d490ea3d323371';

        $deploy = $this->rpcClient->getDeploy($deployHashFromTheTestnet);
        $this->assertEquals(ByteUtil::hexToByteArray($deployHashFromTheTestnet), $deploy->getHash());
        $this->assertNotNull($deploy->getPayment());
        $this->assertNotEmpty($deploy->getApprovals());
    }

    public function testGetDeployByFakeHash(): void
    {
        $fakeDeployHash = '1234567891234567891234567891234567891234567891234567891234567891';
        $errorMessage = 'deploy not know';

        $this->expectException(RpcError::class);
        $this->expectExceptionMessage($errorMessage);
        $this->rpcClient->getDeploy($fakeDeployHash);
    }

    public function testGetLatestBlock(): Block
    {
        $latestBlock = $this->rpcClient->getLatestBlock();
        $this->assertNotEmpty($latestBlock->getHash());
        $this->assertInstanceOf(BlockHeader::class, $latestBlock->getHeader());
        $this->assertInstanceOf(BlockBody::class, $latestBlock->getBody());
        $this->assertIsArray($latestBlock->getProofs());

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

    public function testGetBlockByFakeHash(): void
    {
        $fakeBlockHash = '1234567891234567891234567891234567891234567891234567891234567891';
        $errorMessage = 'block not know';

        $this->expectException(RpcError::class);
        $this->expectExceptionMessage($errorMessage);
        $this->rpcClient->getBlockByHash($fakeBlockHash);
    }

    /**
     * @depends testGetLatestBlock
     */
    public function testGetBlockByHeight(Block $latestBlock): void
    {
        $block = $this->rpcClient->getBlockByHeight($latestBlock->getHeader()->getHeight());
        $this->assertEquals($block->getHash(), $latestBlock->getHash());
    }

    public function testGetBlockByIncorrectHeight(): void
    {
        $this->expectException(RpcError::class);
        $this->rpcClient->getBlockByHeight(-1);
    }

    public function testGetPeers(): void
    {
        $peers = $this->rpcClient->getPeers();
        $this->assertIsArray($peers);

        $firstPeer = $peers[0];
        $this->assertNotEmpty($firstPeer->getNodeId());
        $this->assertNotEmpty($firstPeer->getAddress());
    }

    public function testGetStatus(): void
    {
        $status = $this->rpcClient->getStatus();
        $this->assertNotEmpty($status->getApiVersion());
        $this->assertNotEmpty($status->getChainspecName());
        $this->assertNotEmpty($status->getStartingStateRootHash());
        $this->assertNotEmpty($status->getLastAddedBlockInfo()->getHash());
        $this->assertNotEmpty($status->getOurPublicSigningKey()->parsedValue());
        $this->assertNotEmpty($status->getBuildVersion());
        $this->assertNotEmpty($status->getUptime());
        $this->assertNotEmpty($status->getReactorState());
        $this->assertNotEmpty($status->getLastProgress());
        $this->assertNotEmpty($status->getAvailableBlockRange());
    }

    public function testGetAuctionState(): void
    {
        $auctionState = $this->rpcClient->getAuctionState();
        $this->assertNotEmpty($auctionState->getStateRootHash());
        $this->assertGreaterThan(0, $auctionState->getBlockHeight());

        $firstEraValidator = $auctionState->getEraValidators()[0];
        $this->assertGreaterThan(0, $firstEraValidator->getEraId());
        $this->assertNotEmpty($firstEraValidator->getValidatorWeights());

        $firstBid = $auctionState->getBids()[0];
        $this->assertNotEmpty($firstBid->getPublicKey()->value());
    }

    /**
     * @depends testGetLatestBlock
     */
    public function testGetStateRootHash(Block $latestBlock): string
    {
        $stateRootHash = $this->rpcClient->getStateRootHash($latestBlock->getHash());
        $this->assertMatchesRegularExpression('/[a-fA-F\d]{64}/', $stateRootHash);

        return $stateRootHash;
    }

    public function testGetAccount(): Account
    {
        $blockHashFromTheTestnet = '037e916018fd181be3455df1d54e9a1b3a5f1784627b0044201b7ad378542a02';
        $accountPublicKeyFromTheTestnet = CLPublicKeySerializer::fromHex('011b5b2e370411b6df3a3d8ac0063b35e2003994a634dba48dd5422247fc1e7c41');
        $accountHashFromTheTestnet = 'account-hash-7203e3b0592b7ed4f63552829c5887c493e525fb35b842aed68c56bec38f4e6b';

        $account = $this->rpcClient->getAccount($blockHashFromTheTestnet, $accountPublicKeyFromTheTestnet);
        $this->assertEquals($account->getAccountHash()->parsedValue(), $accountHashFromTheTestnet);

        return $account;
    }

    /**
     * @depends testGetStateRootHash
     * @depends testGetAccount
     */
    public function testGetAccountBalance(string $stateRootHash, Account $account): void
    {
        $accountBalance = $this->rpcClient->getAccountBalance($stateRootHash, $account->getMainPurse());
        $this->assertGreaterThanOrEqual(0, gmp_cmp($accountBalance, 0));
    }

    /**
     * @depends testGetStateRootHash
     * @depends testGetAccount
     */
    public function testQueryBalance(string $stateRootHash, Account $account): void
    {
        $accountBalance = $this->rpcClient->queryBalance(
            RpcClient::PURSE_IDENTIFIER_TYPE_UREF,
            $account->getMainPurse()->parsedValue(),
            $stateRootHash
        );
        $this->assertGreaterThanOrEqual(0, gmp_cmp($accountBalance, 0));
    }

    /**
     * @depends testGetStateRootHash
     * @depends testGetAccount
     */
    public function testGetAccountBalanceUrefByAccountHash(string $stateRootHash, Account $account): void
    {
        $accountMainPurse = $this->rpcClient->getAccountBalanceUrefByAccountHash($stateRootHash, $account->getAccountHash());
        $this->assertEquals($account->getMainPurse()->parsedValue(), $accountMainPurse->parsedValue());
    }

    /**
     * @depends testGetStateRootHash
     */
    public function testGetAccountBalanceUrefByAccountPublicKey(string $stateRootHash): void
    {
        $accountPublicKeyFromTheTestnet = CLPublicKeySerializer::fromHex('011b5b2e370411b6df3a3d8ac0063b35e2003994a634dba48dd5422247fc1e7c41');
        $accountMainPurseFromTheTestnet = 'uref-84bc62373fdb3ffabb0c85d8d3dcf80ac780ed9c0afad28f959f697effeef043-007';

        $accountMainPurse = $this->rpcClient->getAccountBalanceUrefByPublicKey($stateRootHash, $accountPublicKeyFromTheTestnet);
        $this->assertEquals($accountMainPurseFromTheTestnet, $accountMainPurse->parsedValue());
    }

    /**
     * @depends testGetStateRootHash
     * @depends testGetAccount
     */
    public function testGetBlockState(string $stateRootHash, Account $account): void
    {
        $accountHash = $account->getAccountHash()->parsedValue();

        $blockState = $this->rpcClient->getBlockState($stateRootHash, $accountHash);
        $this->assertNotNull($blockState->getAccount());
        $this->assertEquals($accountHash, $blockState->getAccount()->getAccountHash()->parsedValue());
    }

    public function testGetBlockTransfers(): void
    {
        $blockHashFromTheTestnet = 'a1f829cff2389cf6637ed89fb2fab48351b1278c131ee8445e1e28333c9a44d0';

        $blockTransfers = $this->rpcClient->getBlockTransfers($blockHashFromTheTestnet);
        $this->assertNotEmpty($blockTransfers);
    }

    public function testGetEraSummaryBySwitchBlockHash(): void
    {
        $switchingBlockHashFromTheTestnet = 'de8649985929090b7cb225e35a5a7b4087fb8fcb3d18c8c9a58da68e4eda8a2e';

        $eraSummary = $this->rpcClient->getEraSummaryBySwitchBlockHash($switchingBlockHashFromTheTestnet);
        $this->assertEquals(1, $eraSummary->getEraId());
        $this->assertEquals($switchingBlockHashFromTheTestnet, strtolower($eraSummary->getBlockHash()));
        $this->assertNotNull($eraSummary->getStoredValue()->getEraInfo());
    }

    public function testGetEraSummaryBySwitchBlockHeight(): void
    {
        $switchingBlockHeightFromTheTestnet = 219;

        $eraSummary = $this->rpcClient->getEraSummaryBySwitchBlockHeight($switchingBlockHeightFromTheTestnet);
        $this->assertEquals(1, $eraSummary->getEraId());
        $this->assertEquals('de8649985929090b7cb225e35a5a7b4087fb8fcb3d18c8c9a58da68e4eda8a2e', strtolower($eraSummary->getBlockHash()));
        $this->assertNotNull($eraSummary->getStoredValue()->getEraInfo());
    }

    public function testGetGlobalStateByBlock(): void
    {
        $blockHashFromTheTestnet = '009516c04e6cb56d1d9b43070fd45cd80bf968739d39555282d8e66a8194e2e3';
        $deployHashFromTheTestnet = 'deploy-39cf80560c87af0e69eb4a2c49f2404842244eafc63c497a6c8eb92f89b3c102';

        $globalState = $this->rpcClient->getGlobalStateByBlock($blockHashFromTheTestnet, $deployHashFromTheTestnet);
        $this->assertEquals($deployHashFromTheTestnet, 'deploy-' . $globalState->getStoredValue()->getDeployInfo()->getDeployHash());
    }

    public function testGetGlobalStateByStateRootHash(): void
    {
        $blockHashFromTheTestnet = '009516c04e6cb56d1d9b43070fd45cd80bf968739d39555282d8e66a8194e2e3';
        $deployHashFromTheTestnet = 'deploy-39cf80560c87af0e69eb4a2c49f2404842244eafc63c497a6c8eb92f89b3c102';
        $stateRootHash = $this->rpcClient->getStateRootHash($blockHashFromTheTestnet);

        $globalState = $this->rpcClient->getGlobalStateByStateRootHash($stateRootHash, $deployHashFromTheTestnet);
        $this->assertEquals($deployHashFromTheTestnet, 'deploy-' . $globalState->getStoredValue()->getDeployInfo()->getDeployHash());
    }

    public function testGetChainspecInfo(): void
    {
        $chainspecInfo = $this->rpcClient->getChainspecInfo();
        $this->assertNotEmpty($chainspecInfo->getChainspecBytes());
    }

    //TODO: Add test for speculative_exec RPC method
}
