<?php

namespace Casper\CLType;

final class CLI64Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::I64);
        $this->linkTo = CLI64::class;
    }
}
