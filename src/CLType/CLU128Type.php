<?php

namespace Casper\CLType;

final class CLU128Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::U128);
        $this->linkTo = CLU128::class;
    }
}
