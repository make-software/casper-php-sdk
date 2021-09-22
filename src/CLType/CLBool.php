<?php

namespace Casper\CLType;

final class CLBool extends CLValue
{
    public function __construct(bool $data)
    {
        $this->data = $data;
    }

    public function value(): bool
    {
        return $this->data;
    }

    public function clType(): CLBoolType
    {
        return new CLBoolType();
    }

    public function toBytes(): array
    {
        return [(int) $this->data];
    }
}
