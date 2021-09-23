<?php

namespace Casper\Entity;

use Casper\Util\ByteUtil;

final class DeployExecutableModuleBytes extends DeployExecutableItemInternal
{
    protected const TAG = 0;

    /**
     * @var int[]
     */
    private array $moduleBytes;

    /**
     * @param int[] $moduleBytes
     */
    public function __construct(array $moduleBytes)
    {
        $this->moduleBytes = $moduleBytes;
    }

    public function getModuleBytes(): array
    {
        return $this->moduleBytes;
    }

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return array_merge(
            [self::TAG],
            ByteUtil::toBytesArrayU8($this->moduleBytes),
            ByteUtil::vectorToBytesU32($this->args)
        );
    }
}
