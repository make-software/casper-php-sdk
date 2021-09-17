<?php

namespace Casper\CLType;

final class CLPublicKeyType extends CLType
{
    private const NAME = 'PublicKey';

    public function __construct()
    {
        $this->tag = CLTypeTag::new(CLTypeTag::PUBLIC_KEY);
        $this->linkTo = CLPublicKey::class;
    }

    public function toString(): string
    {
        return self::NAME;
    }

    public function toJSON(): string
    {
        return self::NAME;
    }
}
