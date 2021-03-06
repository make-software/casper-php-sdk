<?php

namespace Casper\CLType;

final class CLTuple2 extends CLTuple
{
    /**
     * @param CLValue[] $values
     * @throws \Exception
     */
    public function __construct(array $values)
    {
        parent::__construct(2, $values);
    }
}
