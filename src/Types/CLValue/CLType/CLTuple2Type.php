<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLTuple2;
use Casper\Types\CLValue\CLTypeTag;

final class CLTuple2Type extends CLTupleType
{
    public function __construct(array $inner)
    {
        parent::__construct($inner, new CLTypeTag(CLTypeTag::TUPLE2), CLTuple2::class);
    }
}
