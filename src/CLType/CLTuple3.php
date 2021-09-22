<?php

namespace Casper\CLType;

final class CLTuple3 extends CLTuple
{
    /**
     * @param CLValue[] $values
     * @throws \Exception
     */
    public function __construct(array $values)
    {
        parent::__construct(3, $values);
    }
}
