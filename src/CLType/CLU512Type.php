<?php

namespace Casper\CLType;

final class CLU512Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::U512);
        $this->linkTo = CLU512::class;
    }
}
