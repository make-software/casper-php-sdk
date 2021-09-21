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

    /**
     * @param string $id
     * @param string $amount
     * @param CLURef|CLPublicKey $target
     * @param CLURef|null $sourcePurse
     * @return DeployExecutable
     * @throws \Exception
     */
    public function newTransfer(
        string $id,
        string $amount,
        $target,
        CLURef $sourcePurse = null
    ): DeployExecutable
    {
        if ($target instanceof CLURef) {
            $targetValue = $target;
        }
        elseif ($target instanceof CLPublicKey) {
            $targetValue = new CLByteArray($target->toAccountHash());
        }
        else {
            throw new \Exception('Please specify target');
        }

        $transfer = (new DeployExecutableTransfer())
            ->setArg(new DeployNamedArg('target', $targetValue))
            ->setArg(new DeployNamedArg('amount', new CLU512($amount)))
            ->setArg(new DeployNamedArg('id', new CLOption(new CLU64($id))));

        if ($sourcePurse !== null) {
            $transfer->setArg(new DeployNamedArg('source', $sourcePurse));
        }

        return (new DeployExecutable())
            ->setTransfer($transfer);
    }

    public function newStandardPayment(string $amount): DeployExecutable
    {
        $moduleBytes = (new DeployExecutableModuleBytes([]))
            ->setArg(
                new DeployNamedArg('amount', new CLU512($amount))
            );

        return (new DeployExecutable())
            ->setModuleBytes($moduleBytes);
    }
}
