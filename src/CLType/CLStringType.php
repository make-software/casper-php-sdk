<?php

namespace Casper\CLType;

final class CLStringType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::STRING);
        $this->linkTo = CLString::class;
    }
}
