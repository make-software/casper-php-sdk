<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLTypeTag;
use Casper\Types\CLValue\CLU512;

final class CLU512Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::U512);
        $this->linkTo = CLU512::class;
    }
}
