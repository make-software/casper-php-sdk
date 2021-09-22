<?php

namespace Casper\CLType;

final class CLBoolType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::BOOL);
        $this->linkTo = CLBool::class;
    }
}
