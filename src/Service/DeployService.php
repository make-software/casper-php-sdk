<?php

namespace Casper\Services;

use Casper\Model\Deploy;
use Casper\Model\DeployExecutable;
use Casper\Model\DeployHeader;
use Casper\Model\DeployParams;
use Casper\Util\HashUtil;

class DeployService
{
    /**
     * @throws \Exception
     */
    public function makeDeploy(DeployParams $deployParams, DeployExecutable $session, DeployExecutable $payment): Deploy
    {
        $serializedBody = array_merge($payment->toBytes(), $session->toBytes());
        $bodyHash = HashUtil::blake2bHash($serializedBody);

        $header = new DeployHeader(
            $deployParams->getAccountPublicKey(),
            $deployParams->getTimestamp(),
            $deployParams->getTtl(),
            $deployParams->getGasPrice(),
            $bodyHash,
            $deployParams->getDependencies(),
            $deployParams->getChainName()
        );

        return new Deploy(
            HashUtil::blake2bHash($header->toBytes()),
            $header,
            $payment,
            $session,
            []
        );
    }
}
