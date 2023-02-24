<?php

namespace Casper\Entity;

use Casper\CLType\CLOption;
use Casper\CLType\CLPublicKey;
use Casper\CLType\CLU512;
use Casper\CLType\CLU64;
use Casper\CLType\CLURef;

abstract class DeployExecutableFactory
{
    public static function newStandardPayment($amount): DeployExecutableModuleBytes
    {
        return self::newModuleBytes('', [new DeployNamedArg('amount', new CLU512($amount))]);
    }

    public static function newTransfer($id, $amount, $target, CLURef $sourcePurse = null): DeployExecutableTransfer
    {
        if (!in_array(get_class($target), [CLURef::class, CLPublicKey::class])) {
            throw new \Exception('Please specify target');
        }

        $transfer = (new DeployExecutableTransfer())
            ->setArg(new DeployNamedArg('amount', new CLU512($amount)));

        if ($sourcePurse !== null) {
            $transfer->setArg(new DeployNamedArg('source', $sourcePurse));
        }

        return $transfer
            ->setArgs([
                new DeployNamedArg('target', $target),
                new DeployNamedArg('id', new CLOption(new CLU64($id)))
            ]);
    }

    public static function newModuleBytes(string $hexModuleBytes, array $args): DeployExecutableModuleBytes
    {
        return (new DeployExecutableModuleBytes($hexModuleBytes))
            ->setArgs($args);
    }

    public static function newStoredContractByHash(
        string $entrypoint,
        array $args,
        string $hexContractHash
    ): DeployExecutableStoredContractByHash {
        return (new DeployExecutableStoredContractByHash($hexContractHash, $entrypoint))
            ->setArgs($args);
    }

    public static function newStoredContractByName(
        string $entrypoint,
        array $args,
        string $contractAlias
    ): DeployExecutableStoredContractByName {
        return (new DeployExecutableStoredContractByName($contractAlias, $entrypoint))
            ->setArgs($args);
    }

    public static function newStoredContractPackageByHash(
        string $entrypoint,
        array $args,
        string $hexContractPackageHash,
        int $version = null
    ): DeployExecutableStoredVersionedContractByHash {
        return (new DeployExecutableStoredVersionedContractByHash($hexContractPackageHash, $entrypoint, $version))
            ->setArgs($args);
    }

    public static function newStoredContractPackageByName(
        string $entrypoint,
        array $args,
        string $contractPackageAlias,
        int $version = null
    ): DeployExecutableStoredVersionedContractByName {
        return (new DeployExecutableStoredVersionedContractByName($contractPackageAlias, $entrypoint, $version))
            ->setArgs($args);
    }
}
