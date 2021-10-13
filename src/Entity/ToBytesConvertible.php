<?php

namespace Casper\Entity;

interface ToBytesConvertible
{
    /**
     * @return int[]
     */
    public function toBytes(): array;
}
