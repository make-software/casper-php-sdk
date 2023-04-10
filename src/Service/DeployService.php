<?php

namespace Casper\Service;

use Casper\Serializer\CLPublicKeySerializer;
use Casper\Util\ByteUtil;
use Casper\Util\Crypto\AsymmetricKey;
use Casper\Util\HashUtil;
use Casper\Util\KeysUtil;

use Casper\Entity\Deploy;
use Casper\Entity\DeployApproval;
use Casper\Entity\DeployExecutable;
use Casper\Entity\DeployHeader;
use Casper\Entity\DeployParams;

/**
 * Class that allows performs operations around Deploy object
 */
class DeployService
{
    /**
     * Construct the unsigned Deploy
     *
     * @param DeployParams $deployParams
     * @param DeployExecutable $session
     * @param DeployExecutable $payment
     * @return Deploy
     *
     * @throws \Exception
     */
    public static function makeDeploy(
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
     * Add signature to the Deploy
     *
     * @param Deploy $deploy
     * @param AsymmetricKey $key
     * @return Deploy
     *
     * @throws \Exception
     */
    public static function signDeploy(Deploy $deploy, AsymmetricKey $key): Deploy
    {
        $signer = CLPublicKeySerializer::fromString(
            KeysUtil::addPrefixToPublicKey(
                $key->getSignatureAlgorithm(),
                $key->getPublicKey()
            )
        );
        $signature = KeysUtil::addPrefixToPublicKey(
            $key->getSignatureAlgorithm(),
            $key->sign(ByteUtil::byteArrayToString($deploy->getHash()))
        );

        return $deploy
            ->pushApproval(new DeployApproval($signer, $signature));
    }

    /**
     * Validate the Deploy by checking body and deploy hash
     *
     * @param Deploy $deploy
     * @return bool
     *
     * @throws \Exception
     */
    public static function validateDeploy(Deploy $deploy): bool
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
     * Get deploy size in bytes
     *
     * @param Deploy $deploy
     * @return int
     *
     * @throws \Exception
     */
    public static function getDeploySize(Deploy $deploy): int
    {
        $hashSize = count($deploy->getHash());
        $bodySize = count(array_merge($deploy->getPayment()->toBytes(), $deploy->getSession()->toBytes()));
        $headerSize = count($deploy->getHeader()->toBytes());
        $approvalsSize = 0;

        foreach ($deploy->getApprovals() as $approval) {
            $approvalsSize += (strlen(CLPublicKeySerializer::toHex($approval->getSigner())) + strlen($approval->getSignature())) / 2;
        }

        return $hashSize + $bodySize + $headerSize + $approvalsSize;
    }
}
