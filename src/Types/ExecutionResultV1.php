<?php

namespace Casper\Types;

class ExecutionResultV1
{
    private ?ExecutionResultStatusData $success;

    private ?ExecutionResultStatusData $failure;

    public function __construct(?ExecutionResultStatusData $success, ?ExecutionResultStatusData $failure)
    {
        $this->success = $success;
        $this->failure = $failure;
    }

    public function getSuccess(): ?ExecutionResultStatusData
    {
        return $this->success;
    }

    public function getFailure(): ?ExecutionResultStatusData
    {
        return $this->failure;
    }
}
