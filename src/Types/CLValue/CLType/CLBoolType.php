<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLBool;
use Casper\Types\CLValue\CLTypeTag;

final class CLBoolType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::BOOL);
        $this->linkTo = CLBool::class;
    }
}
