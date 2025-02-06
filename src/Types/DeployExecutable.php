<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLOption;
use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\CLValue\CLU512;
use Casper\Types\CLValue\CLU64;
use Casper\Types\CLValue\CLURef;

abstract class DeployExecutable implements ToBytesConvertible
{
    public static function newStandardPayment($amount): DeployExecutableModuleBytes
    {
        return self::newModuleBytes('', [new NamedArg('amount', new CLU512($amount))]);
    }

    public static function newTransfer($id, $amount, $target, CLURef $sourcePurse = null): DeployExecutableTransfer
    {
        if (!in_array(get_class($target), [CLURef::class, CLPublicKey::class])) {
            throw new \Exception('Please specify target');
        }

        $transfer = (new DeployExecutableTransfer())
            ->setArg(new NamedArg('amount', new CLU512($amount)));

        if ($sourcePurse !== null) {
            $transfer->setArg(new NamedArg('source', $sourcePurse));
        }

        return $transfer
            ->setArgs([
                new NamedArg('target', $target),
                new NamedArg('id', new CLOption(new CLU64($id)))
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

    /**
     * @var NamedArg[]
     */
    protected array $args = array();

    public function setArg(NamedArg $deployNamedArg): self
    {
        $this->args[] = $deployNamedArg;
        return $this;
    }

    public function setArgs(array $deployNamedArgs): self
    {
        foreach ($deployNamedArgs as $deployNamedArg) {
            $this->setArg($deployNamedArg);
        }

        return $this;
    }

    /**
     * @return NamedArg[]
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    public function getArgByName(string $name): ?NamedArg
    {
        foreach ($this->args as $arg) {
            if ($arg->getName() === $name) {
                return $arg;
            }
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    public function getArgParsedValueByName(string $name)
    {
        $arg = $this->getArgByName($name);

        if (!$arg) {
            throw new \Exception('Argument not found');
        }

        return $arg->getValue()
            ->parsedValue();
    }
}
