<?php

namespace Casper\Entity;

use Casper\Util\ByteUtil;

class DeployExecutableStoredContractByHash extends DeployExecutableItemInternal
{
    protected const TAG = 1;

    protected string $hash;

    protected string $entryPoint;

    public function __construct(string $hash, string $entryPoint)
    {
        $this->hash = $hash;
        $this->entryPoint = $entryPoint;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getEntryPoint(): string
    {
        return $this->entryPoint;
    }

    /**
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return array_merge(
            [self::TAG],
            ByteUtil::hexToByteArray($this->hash),
            ByteUtil::stringToBytesU32($this->entryPoint),
            ByteUtil::vectorToBytesU32($this->args)
        );
    }
}
