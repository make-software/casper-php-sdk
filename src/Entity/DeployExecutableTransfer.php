<?php

namespace Casper\Entity;

use Casper\Util\ByteUtil;

final class DeployExecutableTransfer extends DeployExecutable
{
    protected const TAG = 5;

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return array_merge([self::TAG], ByteUtil::vectorToBytesU32($this->args));
    }
}
