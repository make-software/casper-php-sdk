<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLAccountHash;

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
