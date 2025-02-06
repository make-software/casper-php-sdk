<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLTypeTag;
use Casper\Types\CLValue\CLU128;

final class CLU128Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::U128);
        $this->linkTo = CLU128::class;
    }
}
