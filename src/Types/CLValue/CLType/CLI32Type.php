<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLI32;
use Casper\Types\CLValue\CLTypeTag;

final class CLI32Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::I32);
        $this->linkTo = CLI32::class;
    }
}
