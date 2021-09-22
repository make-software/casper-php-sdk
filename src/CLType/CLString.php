<?php

namespace Casper\CLType;

use Casper\Util\ByteUtil;

final class CLString extends CLValue
{
    public function __construct(string $value)
    {
        $this->data = $value;
    }

    public function value(): string
    {
        return $this->data;
    }

    public function clType(): CLStringType
    {
        return new CLStringType();
    }

    /**
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return ByteUtil::stringToBytesU32($this->data);
    }
}
