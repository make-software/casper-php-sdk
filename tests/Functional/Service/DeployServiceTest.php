<?php

namespace Tests\Functional\Services;

use PHPUnit\Framework\TestCase;

use Casper\Serializer\CLPublicKeySerializer;
use Casper\Util\ByteUtil;
use Casper\Util\Crypto\Ed25519Key;

use Casper\Service\DeployService;

use Casper\Entity\Deploy;
use Casper\Entity\DeployApproval;
use Casper\Entity\DeployExecutable;
use Casper\Entity\DeployParams;

class DeployServiceTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testMakeDeploy(): Deploy
    {
        $senderPublicKey = CLPublicKeySerializer::fromAsymmetricKey(new Ed25519Key());
        $networkName = 'test-network';
        $deployParams = new DeployParams($senderPublicKey, $networkName);

        $transferId = 1;
        $transferAmount = 2500000000;
        $fakePublicKeyHex = '0202181123456789693bcd1066f00abe6759c588efe94504a7c9911be77ec365c08e';
        $recipientPublicKey = CLPublicKeySerializer::fromHex($fakePublicKeyHex);
        $transfer = DeployExecutable::newTransfer($transferId, $transferAmount, $recipientPublicKey);

        $paymentAmount = 10;
        $payment = DeployExecutable::newStandardPayment($paymentAmount);

        $deploy = DeployService::makeDeploy($deployParams, $transfer, $payment);

        $createdDeployChainName = $deploy->getHeader()
            ->getChainName();
        $this->assertEquals($networkName, $createdDeployChainName);

        // Check deploy transfer
        $createdDeployTransfer = $deploy->getSession()
            ->getTransfer();
        $this->assertNotNull($createdDeployTransfer);

        $createdDeployTransferId = (int) $createdDeployTransfer->getArgParsedValueByName('id');
        $this->assertEquals($transferId, $createdDeployTransferId);

        $createdDeployTransferAmount = (int) $createdDeployTransfer->getArgParsedValueByName('amount');
        $this->assertEquals($transferAmount, $createdDeployTransferAmount);

        $createdDeployTransferTarget = $createdDeployTransfer->getArgParsedValueByName('target');
        $this->assertEquals($fakePublicKeyHex, $createdDeployTransferTarget);

        // Check deploy payment
        $createdDeployPayment = $deploy->getPayment();
        $this->assertNotNull($createdDeployPayment->getModuleBytes());

        $createdDeployPaymentAmount = (int) $createdDeployPayment->getModuleBytes()
            ->getArgParsedValueByName('amount');
        $this->assertEquals($paymentAmount, $createdDeployPaymentAmount);

        return $deploy;
    }

    /**
     * @depends testMakeDeploy
     * @throws \Exception
     */
    public function testSignDeploy(Deploy $deploy): void
    {
        $this->assertEmpty($deploy->getApprovals());

        $ed25519KeyPair = new Ed25519Key();
        DeployService::signDeploy($deploy, $ed25519KeyPair);

        $approvals = $deploy->getApprovals();
        $this->assertNotEmpty($approvals);

        $approval = $approvals[0];
        $this->assertInstanceOf(DeployApproval::class, $approval);
        $this->assertEquals(
            $ed25519KeyPair->getPublicKey(),
            ByteUtil::byteArrayToHex($approval->getSigner()->value())
        );
    }

    /**
     * @depends testMakeDeploy
     * @throws \Exception
     */
    public function testValidateDeploy(Deploy $notCorruptedDeploy): void
    {
        $deployIsValid = DeployService::validateDeploy($notCorruptedDeploy);
        $this->assertTrue($deployIsValid);

        // Change hash in deploy object and check if deploy is valid
        $corruptedDeploy = clone $notCorruptedDeploy;
        $reflectionObject = new \ReflectionObject($corruptedDeploy);
        $reflectionProperty = $reflectionObject->getProperty('hash');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($corruptedDeploy, array_merge($corruptedDeploy->getHash(), [1]));

        $deployIsValid = DeployService::validateDeploy($corruptedDeploy);
        $this->assertFalse($deployIsValid);
    }

    /**
     * @depends testMakeDeploy
     * @throws \Exception
     */
    public function testGetDeploySize(Deploy $deploy): void
    {
        // Remove all approvals from the deploy
        $notSignedDeploy = clone $deploy;
        $reflectionObject = new \ReflectionObject($notSignedDeploy);
        $reflectionProperty = $reflectionObject->getProperty('approvals');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($notSignedDeploy, []);

        $hashSize = count($notSignedDeploy->getHash());
        $headerSize = count($notSignedDeploy->getHeader()->toBytes());
        $bodySize = count(array_merge($notSignedDeploy->getPayment()->toBytes(), $notSignedDeploy->getSession()->toBytes()));

        $expectedNotSignedDeploySize = $hashSize + $headerSize + $bodySize;
        $actualNotSignedDeploySize = DeployService::getDeploySize($notSignedDeploy);

        $this->assertEquals($expectedNotSignedDeploySize, $actualNotSignedDeploySize);
    }
}
