<?php

namespace Casper\CLType;

final class CLU256Type extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::U256);
        $this->linkTo = CLU256::class;
    }
}
