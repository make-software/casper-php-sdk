<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLI64;
use Casper\Types\CLValue\CLTypeTag;

final class CLI64Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::I64);
        $this->linkTo = CLI64::class;
    }
}
