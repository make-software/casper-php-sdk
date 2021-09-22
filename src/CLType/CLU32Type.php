<?php

namespace Casper\CLType;

final class CLU32Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::U32);
        $this->linkTo = CLU32::class;
    }
}
