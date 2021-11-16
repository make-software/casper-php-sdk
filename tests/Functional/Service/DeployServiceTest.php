<?php

namespace Tests\Functional\Services;

use PHPUnit\Framework\TestCase;

use Casper\Serializer\CLPublicKeySerializer;
use Casper\Util\ByteUtil;
use Casper\Util\Crypto\Ed25519Key;

use Casper\Service\DeployService;

use Casper\Entity\DeployExecutable;
use Casper\Entity\DeployParams;

class DeployServiceTest extends TestCase
{
    protected ?DeployService $deployService;

    protected function setUp(): void
    {
        $this->deployService = new DeployService();
    }

    protected function tearDown(): void
    {
        $this->deployService = null;
    }

    /**
     * @throws \Exception
     */
    public function testMakeDeploy(): void
    {
        $senderPublicKey = CLPublicKeySerializer::fromAsymmetricKey(new Ed25519Key());
        $networkName = 'test-network';
        $deployParams = new DeployParams($senderPublicKey, $networkName);

        $transferId = 1;
        $transferAmount = 2500000000;
        $fakePublicKeyHex = '0202181123456789693bcd1066f00abe6759c588efe94504a7c9911be77ec365c08e';
        $recipientPublicKey = CLPublicKeySerializer::fromHex($fakePublicKeyHex);
        $recipientAccountHashString = ByteUtil::byteArrayToHex($recipientPublicKey->toAccountHash());
        $transfer = DeployExecutable::newTransfer($transferId, $transferAmount, $recipientPublicKey);

        $paymentAmount = 10;
        $payment = DeployExecutable::newStandardPayment($paymentAmount);

        $deploy = $this->deployService
            ->makeDeploy($deployParams, $transfer, $payment);

        $createdDeployChainName = $deploy->getHeader()->getChainName();
        $this->assertEquals($networkName, $createdDeployChainName);

        $createdDeployTransfer = $deploy->getSession()->getTransfer();
        $this->assertNotNull($createdDeployTransfer);

        $createdDeployTransferId = (int) $createdDeployTransfer
            ->getArgByName('id')
            ->getValue()
            ->parsedValue();
        $this->assertEquals($transferId, $createdDeployTransferId);

        $createdDeployTransferAmount = (int) $createdDeployTransfer
            ->getArgByName('amount')
            ->getValue()
            ->parsedValue();
        $this->assertEquals($transferAmount, $createdDeployTransferAmount);

        $createdDeployTargetAccountHashString = $createdDeployTransfer
            ->getArgByName('target')
            ->getValue()
            ->parsedValue();
        $this->assertEquals($recipientAccountHashString, $createdDeployTargetAccountHashString);

        $createdDeployPayment = $deploy->getPayment();
        $this->assertNotNull($createdDeployPayment->getModuleBytes());
    }
}
