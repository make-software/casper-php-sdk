<?php

namespace Casper\CLType;

abstract class CLValue
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @return mixed
     */
    abstract public function value();

    abstract public function clType(): CLType;
}
