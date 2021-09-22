<?php

namespace Casper\CLType;

final class CLTuple1 extends CLTuple
{
    /**
     * @param CLValue[] $values
     * @throws \Exception
     */
    public function __construct(array $values)
    {
        parent::__construct(1, $values);
    }
}
