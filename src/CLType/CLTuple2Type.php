<?php

namespace Casper\CLType;

final class CLTuple2Type extends CLTupleType
{
    public function __construct(array $inner)
    {
        parent::__construct($inner, new CLTypeTag(CLTypeTag::TUPLE2), CLTuple2::class);
    }
}
