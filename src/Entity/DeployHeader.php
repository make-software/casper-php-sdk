<?php

namespace Casper\Entity;

use Casper\CLType\CLPublicKey;
use Casper\Interfaces\ToBytesInterface;
use Casper\Util\ByteUtil;

class DeployHeader implements ToBytesInterface
{
    private CLPublicKey $account;

    private int $timestamp;

    private int $ttl;

    private int $gasPrice;

    /**
     * @var int[]
     */
    private array $bodyHash;

    /**
     * @var int[][]
     */
    private array $dependencies;

    private string $chainName;

    /**
     * @param CLPublicKey $account
     * @param int $timestamp
     * @param int $ttl
     * @param int $gasPrice
     * @param int[] $bodyHash
     * @param int[][] $dependencies
     * @param string $chainName
     */
    public function __construct(
        CLPublicKey $account,
        int $timestamp,
        int $ttl,
        int $gasPrice,
        array $bodyHash,
        array $dependencies,
        string $chainName
    )
    {
        $this->account = $account;
        $this->timestamp = $timestamp;
        $this->ttl = $ttl;
        $this->gasPrice = $gasPrice;
        $this->bodyHash = $bodyHash;
        $this->dependencies = $dependencies;
        $this->chainName = $chainName;
    }

    public function getAccount(): CLPublicKey
    {
        return $this->account;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    public function getGasPrice(): int
    {
        return $this->gasPrice;
    }

    public function getBodyHash(): array
    {
        return $this->bodyHash;
    }

    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    public function getChainName(): string
    {
        return $this->chainName;
    }

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return array_merge(
            $this->account->toBytes(),
            ByteUtil::toBytesU64($this->timestamp),
            ByteUtil::toBytesU64($this->ttl),
            ByteUtil::toBytesU64($this->gasPrice),
            $this->bodyHash,
            ByteUtil::vectorToBytesU32(array_map(
                function (array $hash) {
                    return new DeployHash($hash);
                },
                $this->dependencies
            )),
            ByteUtil::stringToBytesU32($this->chainName)
        );
    }
}
