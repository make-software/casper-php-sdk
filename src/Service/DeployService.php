<?php

namespace Casper\Service;

use Casper\Entity\DeployExecutableModuleBytes;
use Casper\Util\HashUtil;

use Casper\CLType\CLByteArray;
use Casper\CLType\CLOption;
use Casper\CLType\CLPublicKey;
use Casper\CLType\CLU512;
use Casper\CLType\CLU64;
use Casper\CLType\CLURef;

use Casper\Entity\DeployExecutableTransfer;
use Casper\Entity\Deploy;
use Casper\Entity\DeployExecutable;
use Casper\Entity\DeployHeader;
use Casper\Entity\DeployNamedArg;
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
