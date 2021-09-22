<?php

namespace Casper\CLType;

final class CLKeyType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::KEY);
        $this->linkTo = CLKey::class;
    }
}
