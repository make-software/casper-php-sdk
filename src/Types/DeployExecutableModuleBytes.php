<?php

namespace Casper\Types;

use Casper\Util\ByteUtil;

final class DeployExecutableModuleBytes extends DeployExecutable
{
    protected const TAG = 0;

    private string $hexModuleBytes;

    /**
     * @param string $hexModuleBytes
     */
    public function __construct(string $hexModuleBytes)
    {
        $this->hexModuleBytes = $hexModuleBytes;
    }

    public function getHexModuleBytes(): string
    {
        return $this->hexModuleBytes;
    }

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return array_merge(
            [self::TAG],
            ByteUtil::toBytesArrayU8(ByteUtil::hexToByteArray($this->hexModuleBytes)),
            ByteUtil::vectorToBytesU32($this->args)
        );
    }
}
