<?php

namespace Casper\Service;

use Casper\Util\HashUtil;
use Casper\Util\KeysUtil;

use Casper\Entity\AsymmetricKey;
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
        $signer = $key->accountHex();
        $signature = KeysUtil::accountHex($key->getSignatureAlgorithm(), $key->sign($deploy->getHash()));

        return $deploy
            ->pushApproval(new DeployApproval($signer, $signature));
    }
}
