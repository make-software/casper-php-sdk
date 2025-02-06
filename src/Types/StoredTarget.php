<?php

namespace Casper\Types;

class StoredTarget
{
    private TransactionInvocationTarget $id;

    private TransactionRuntime $runtime;

    public function __construct(TransactionInvocationTarget $id, TransactionRuntime $runtime)
    {
        $this->id = $id;
        $this->runtime = $runtime;
    }

    public function getId(): TransactionInvocationTarget
    {
        return $this->id;
    }

    public function getRuntime(): TransactionRuntime
    {
        return $this->runtime;
    }
}
