<?php

namespace Casper\Types\CLValue\CLType;

use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\CLValue\CLTypeTag;

final class CLPublicKeyType extends CLType
{
    public function __construct()
    {
        $this->tag = new CLTypeTag(CLTypeTag::PUBLIC_KEY);
        $this->linkTo = CLPublicKey::class;
    }
}
