<?php

namespace Casper\CLType;

final class CLI32Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::I32);
        $this->linkTo = CLI32::class;
    }
}
