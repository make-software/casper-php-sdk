<?php

namespace Casper\Types;

use Casper\Util\ByteUtil;
use Casper\Types\CLValue\CLValue;

class NamedArg implements ToBytesConvertible
{
    /**
     * Argument name mapped to an entry point parameter.
     */
    private string $name;

    /**
     * Argument value.
     */
    private CLValue $value;

    public function __construct(string $name, CLValue $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): CLValue
    {
        return $this->value;
    }

    /**
     * @return int[]
     * @throws \Exception
     */
    public function toBytes(): array
    {
        return array_merge(
            ByteUtil::stringToBytesU32($this->name),
            $this->value->toBytesWithType()
        );
    }
}
