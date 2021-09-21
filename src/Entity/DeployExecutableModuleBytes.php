<?php

namespace Casper\Model;

use Casper\Util\ByteUtil;

final class DeployExecutableModuleBytes extends DeployExecutableItemInternal
{
    protected const TAG = 1;

    /**
     * @var int[]
     */
    private array $moduleBytes;

    /**
     * @param int[] $moduleBytes
     * @param DeployNamedArg[] $args
     */
    public function __construct(array $moduleBytes, array $args)
    {
        $this->moduleBytes = $moduleBytes;
        $this->args = $args;
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
