<?php

namespace Casper\Types;

interface ToBytesConvertible
{
    /**
     * @return int[]
     */
    public function toBytes(): array;
}
