<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLTypeTag;

final class CLURefType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::UREF);
        $this->linkTo = CLType::class;
    }
}
