<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLTypeTag;
use Casper\Types\CLValue\CLU32;

final class CLU32Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::U32);
        $this->linkTo = CLU32::class;
    }
}
