<?php

namespace Casper\CLType;

final class CLPublicKeyType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::PUBLIC_KEY);
        $this->linkTo = CLPublicKey::class;
    }
}
