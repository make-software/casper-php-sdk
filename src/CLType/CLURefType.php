<?php

namespace Casper\CLType;

final class CLURefType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::UREF);
        $this->linkTo = CLType::class;
    }
}
