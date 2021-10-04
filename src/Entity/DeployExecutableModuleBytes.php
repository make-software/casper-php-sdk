<?php

namespace Casper\Entity;

use Casper\Util\ByteUtil;

final class DeployExecutableModuleBytes extends DeployExecutableItemInternal
{
    protected const TAG = 0;

    private string $moduleBytes;

    /**
     * @param string $moduleBytes
     */
    public function __construct(string $moduleBytes)
    {
        $this->moduleBytes = $moduleBytes;
    }

    public function getModuleBytes(): string
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
            ByteUtil::toBytesArrayU8(ByteUtil::hexToByteArray($this->moduleBytes)),
            ByteUtil::vectorToBytesU32($this->args)
        );
    }
}
