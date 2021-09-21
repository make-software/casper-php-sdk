<?php

namespace Casper\Model;

use Casper\CLType\CLPublicKey;

class DeployParams
{
    const DEFAULT_GAS_PRICE = 1;
    const DEFAULT_TTL = 1800000;

    /**
     * The public key of the account
     */
    private CLPublicKey $accountPublicKey;

    /**
     * Name of the chain, to avoid the `Deploy` from being accidentally or maliciously included in a different chain.
     */
    private string $chainName;

    /**
     * Conversion rate between the cost of Wasm opcodes and the motes sent by the payment code.
     */
    private int $gasPrice;

    /**
     * Time that the `Deploy` will remain valid for, in milliseconds. The default value is 1800000, which is 30 minutes
     */
    private int $ttl;

    /**
     * Hex-encoded `Deploy` hashes of deploys which must be executed before this one.
     */
    private array $dependencies;

    /**
     * If `timestamp` is empty, the current time will be used. Note that timestamp is UTC, not local.
     */
    private int $timestamp;

    public function __construct(
        CLPublicKey $accountPublicKey,
        string $chainName,
        int $gasPrice = self::DEFAULT_GAS_PRICE,
        int $ttl = self::DEFAULT_TTL,
        array $dependencies = [],
        int $timestamp = null
    )
    {
        $this->accountPublicKey = $accountPublicKey;
        $this->chainName = $chainName;
        $this->gasPrice = $gasPrice;
        $this->ttl = $ttl;
        $this->dependencies = $dependencies;
        $this->timestamp = $timestamp ?? time();
    }

    public function getAccountPublicKey(): CLPublicKey
    {
        return $this->accountPublicKey;
    }

    public function getChainName(): string
    {
        return $this->chainName;
    }

    public function getGasPrice(): int
    {
        return $this->gasPrice;
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }
}
