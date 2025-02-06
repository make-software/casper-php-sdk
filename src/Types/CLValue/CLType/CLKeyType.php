<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLKey;
use Casper\Types\CLValue\CLTypeTag;

final class CLKeyType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::KEY);
        $this->linkTo = CLKey::class;
    }
}
