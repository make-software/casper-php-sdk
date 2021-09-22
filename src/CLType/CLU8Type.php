<?php

namespace Casper\CLType;

final class CLU8Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::U8);
        $this->linkTo = CLU8::class;
    }
}
