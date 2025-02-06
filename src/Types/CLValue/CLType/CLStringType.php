<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLString;
use Casper\Types\CLValue\CLTypeTag;

final class CLStringType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::STRING);
        $this->linkTo = CLString::class;
    }
}
