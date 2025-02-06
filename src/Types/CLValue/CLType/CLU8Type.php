<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLTypeTag;
use Casper\Types\CLValue\CLU8;

final class CLU8Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::U8);
        $this->linkTo = CLU8::class;
    }
}
