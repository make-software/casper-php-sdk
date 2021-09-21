<?php

namespace Casper\CLType;

use Casper\Interfaces\ToBytesInterface;
use Casper\Util\ByteUtil;

abstract class CLValue implements ToBytesInterface
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @return mixed
     */
    abstract public function value();

    abstract public function clType(): CLType;

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytesWithType(): array
    {
        return array_merge(
            ByteUtil::toBytesArrayU8($this->toBytes()),
            $this->clType()->toBytes()
        );
    }
}
