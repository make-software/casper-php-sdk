<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLTuple1;
use Casper\Types\CLValue\CLTypeTag;

final class CLTuple1Type extends CLTupleType
{
    public function __construct(array $inner)
    {
        parent::__construct($inner, new CLTypeTag(CLTypeTag::TUPLE1), CLTuple1::class);
    }
}
