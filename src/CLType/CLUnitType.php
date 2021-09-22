<?php

namespace Casper\CLType;

final class CLUnitType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::UNIT);
        $this->linkTo = CLUnit::class;
    }
}
