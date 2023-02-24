<?php

namespace Casper\Service;

use Casper\Entity\DeployNamedArg;
use Casper\Rpc\RpcClient;
use Casper\Util\ByteUtil;
use Casper\Util\Crypto\AsymmetricKey;

use Casper\CLType\CLPublicKey;

use Casper\Entity\Deploy;
use Casper\Entity\DeployExecutableFactory;
use Casper\Entity\DeployParams;

class ContractService
{
    private RpcClient $rpcClient;

    private string $contractHash;

    /**
     * @param array $wasm                   Bytes array representation of a WebAssembly compiled smart contract
     * @param DeployNamedArg[] $args        The runtime arguments for the installment deploy
     * @param string $paymentAmount         The gas payment in motes, where 1 mote = 10^-9 CSPR
     * @param CLPublicKey $sender           CLPublicKey of the sender of the installment deploy
     * @param string $chainName             The name of the network the installment deploy will be sent to. You can get the network name of a node by calling the REST endpoint `:8888/status`
     * @param AsymmetricKey[] $signingKeys  An array of keypairs used to sign the deploy. If you are signing with one key, use an array with only the one keypair. If instead you are utilizing multi-sig functionality, provide multiple keypair objects in the array.
     *
     * @return Deploy
     * @throws \Exception
     */
    public static function createInstallDeploy(
        array $wasm,
        array $args,
        string $paymentAmount,
        CLPublicKey $sender,
        string $chainName,
        array $signingKeys
    ): Deploy {
        $deploy = DeployService::makeDeploy(
            new DeployParams($sender, $chainName),
            DeployExecutableFactory::newModuleBytes(ByteUtil::byteArrayToHex($wasm), $args),
            DeployExecutableFactory::newStandardPayment($paymentAmount)
        );

        foreach ($signingKeys as $signingKey) {
            DeployService::signDeploy($deploy, $signingKey);
        }

        return $deploy;
    }

    /**
     * @param RpcClient $rpcClient
     * @param array $wasm
     * @param DeployNamedArg[] $args
     * @param string $paymentAmount
     * @param CLPublicKey $sender
     * @param string $chainName
     * @param AsymmetricKey[] $signingKeys
     *
     * @return string
     * @throws \Casper\Rpc\RpcError
     */
    public static function install(
        RpcClient $rpcClient,
        array $wasm,
        array $args,
        string $paymentAmount,
        CLPublicKey $sender,
        string $chainName,
        array $signingKeys
    ): string {
        return $rpcClient->putDeploy(
            self::createInstallDeploy(
                $wasm,
                $args,
                $paymentAmount,
                $sender,
                $chainName,
                $signingKeys
            )
        );
    }

    public function __construct(RpcClient $rpcClient, string $contractHash)
    {
        $this->rpcClient = $rpcClient;
        $this->contractHash = $contractHash;
    }

    /**
     * @param string $entrypoint            Name of an entrypoint of a smart contract that you wish to call
     * @param DeployNamedArg[] $args        The runtime arguments for the deploy
     * @param string $paymentAmount         The gas payment in motes, where 1 mote = 10^-9 CSPR.
     * @param CLPublicKey $sender           CLPublicKey of the sender of the deploy
     * @param string $chainName             The name of the network the installment deploy will be sent to. You can get the network name of a node by calling the REST endpoint `:8888/status`
     * @param AsymmetricKey[] $signingKeys  An array of keypairs used to sign the deploy. If you are signing with one key, use an array with only the one keypair. If instead you are utilizing multi-sig functionality, provide multiple keypair objects in the array.
     * @param int $ttl                      The time that the deploy has to live. If the deploy awaits execution longer than this interval, in seconds, then the deploy will fail.
     *
     * @return Deploy
     * @throws \Exception
     */
    public function createCallEntryPointDeploy(
        string $entrypoint,
        array $args,
        string $paymentAmount,
        CLPublicKey $sender,
        string $chainName,
        array $signingKeys,
        int $ttl = DeployParams::DEFAULT_TTL
    ): Deploy {
        $deploy = DeployService::makeDeploy(
            new DeployParams($sender, $chainName, 1, $ttl),
            DeployExecutableFactory::newStoredContractByHash($entrypoint, $args, $this->contractHash),
            DeployExecutableFactory::newStandardPayment($paymentAmount)
        );

        foreach ($signingKeys as $signingKey) {
            DeployService::signDeploy($deploy, $signingKey);
        }

        return $deploy;
    }

    /**
     * @param string $entrypoint
     * @param DeployNamedArg[] $args
     * @param string $paymentAmount
     * @param CLPublicKey $sender
     * @param string $chainName
     * @param AsymmetricKey[] $signingKeys
     * @param int $ttl
     *
     * @return string
     * @throws \Casper\Rpc\RpcError
     */
    public function callEntryPoint(
        string $entrypoint,
        array $args,
        string $paymentAmount,
        CLPublicKey $sender,
        string $chainName,
        array $signingKeys,
        int $ttl = DeployParams::DEFAULT_TTL
    ): string {
        return $this->rpcClient
            ->putDeploy(
                self::createCallEntryPointDeploy(
                    $entrypoint,
                    $args,
                    $paymentAmount,
                    $sender,
                    $chainName,
                    $signingKeys,
                    $ttl
                )
            );
    }
}
