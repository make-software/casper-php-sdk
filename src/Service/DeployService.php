<?php

namespace Casper\Service;

use Casper\Util\ByteUtil;
use Casper\Util\Crypto\AsymmetricKey;
use Casper\Util\HashUtil;
use Casper\Util\KeysUtil;

use Casper\Entity\Deploy;
use Casper\Entity\DeployApproval;
use Casper\Entity\DeployExecutable;
use Casper\Entity\DeployHeader;
use Casper\Entity\DeployParams;

class DeployService
{
    /**
     * @throws \Exception
     */
    public function makeDeploy(
        DeployParams $deployParams,
        DeployExecutable $session,
        DeployExecutable $payment
    ): Deploy
    {
        $bodyHash = HashUtil::blake2bHash(
            array_merge($payment->toBytes(), $session->toBytes())
        );

        $header = new DeployHeader(
            $deployParams->getAccountPublicKey(),
            $deployParams->getTimestamp(),
            $deployParams->getTtl(),
            $deployParams->getGasPrice(),
            $bodyHash,
            $deployParams->getDependencies(),
            $deployParams->getChainName()
        );

        return new Deploy(HashUtil::blake2bHash($header->toBytes()), $header, $payment, $session);
    }

    /**
     * @throws \Exception
     */
    public function signDeploy(Deploy $deploy, AsymmetricKey $key): Deploy
    {
        $signer = KeysUtil::accountHex($key->getSignatureAlgorithm(), $key->getPublicKey());
        $signature = KeysUtil::accountHex(
            $key->getSignatureAlgorithm(),
            $key->sign(
                ByteUtil::byteArrayToHex($deploy->getHash())
            )
        );

        return $deploy
            ->pushApproval(new DeployApproval($signer, $signature));
    }

    /**
     * @throws \Exception
     */
    public function validateDeploy(Deploy $deploy): bool
    {
        $bodyHash = HashUtil::blake2bHash(
            array_merge($deploy->getPayment()->toBytes(), $deploy->getSession()->toBytes())
        );

        if ($deploy->getHeader()->getBodyHash() !== $bodyHash) {
            return false;
        }

        $deployHash = HashUtil::blake2bHash($deploy->getHeader()->toBytes());

        if ($deploy->getHash() !== $deployHash) {
            return false;
        }

        return true;
    }

    /**
     * @throws \Exception
     */
    public function getDeploySize(Deploy $deploy): int
    {
        $hashSize = count($deploy->getHash());
        $bodySize = count(array_merge($deploy->getPayment()->toBytes(), $deploy->getSession()->toBytes()));
        $headerSize = count($deploy->getHeader()->toBytes());
        $approvalsSize = 0;

        foreach ($deploy->getApprovals() as $approval) {
            $approvalsSize += (strlen($approval->getSigner()) + strlen($approval->getSignature())) / 2;
        }

        return $hashSize + $bodySize + $headerSize + $approvalsSize;
    }
}
