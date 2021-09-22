<?php

namespace Casper\CLType;

final class CLTuple1Type extends CLTupleType
{
    public function __construct(array $inner)
    {
        parent::__construct($inner, new CLTypeTag(CLTypeTag::TUPLE1), CLTuple1::class);
    }
}
