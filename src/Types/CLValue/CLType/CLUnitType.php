<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLTypeTag;
use Casper\Types\CLValue\CLUnit;

final class CLUnitType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::UNIT);
        $this->linkTo = CLUnit::class;
    }
}
