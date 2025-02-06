<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLTypeTag;
use Casper\Types\CLValue\CLU64;

final class CLU64Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::U64);
        $this->linkTo = CLU64::class;
    }
}
