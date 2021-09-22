<?php

namespace Casper\CLType;

final class CLAccountHashType extends CLType
{
    public function __construct()
    {
        $this->linkTo = CLAccountHash::class;
    }

    public function toString(): string
    {
        return 'AccountHash (Not Supported as CLValue)';
    }

    public function toBytes(): array
    {
        return [];
    }
}
