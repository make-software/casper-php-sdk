<?php

namespace Casper\Entity;

use Casper\Util\ByteUtil;

final class DeployExecutableStoredContractByName extends DeployExecutableItemInternal
{
    protected const TAG = 2;

    protected string $name;

    protected string $entryPoint;

    public function __construct(string $name, string $entryPoint)
    {
        $this->name = $name;
        $this->entryPoint = $entryPoint;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEntryPoint(): string
    {
        return $this->entryPoint;
    }

    public function toBytes(): array
    {
        return array_merge(
            [self::TAG],
            ByteUtil::stringToBytesU32($this->name),
            ByteUtil::stringToBytesU32($this->entryPoint),
            ByteUtil::vectorToBytesU32($this->args)
        );
    }
}
