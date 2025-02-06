<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLTuple3;
use Casper\Types\CLValue\CLTypeTag;

final class CLTuple3Type extends CLTupleType
{
    public function __construct(array $inner)
    {
        parent::__construct($inner, new CLTypeTag(CLTypeTag::TUPLE3), CLTuple3::class);
    }
}
