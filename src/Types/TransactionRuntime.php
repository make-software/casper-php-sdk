<?php

namespace Casper\Types;

class TransactionRuntime
{
    const VM_CASPER_V1_TAG = 0;
    const VM_CASPER_V2_TAG = 1;

    private int $tag;

    public function __construct(string $tag)
    {
        if (!in_array($tag, [self::VM_CASPER_V1_TAG, self::VM_CASPER_V2_TAG])) {
            throw new \Exception('Unknown TransactionRuntime ' . $tag);
        }

        $this->tag = $tag;
    }

    public function getTag(): int
    {
        return $this->tag;
    }
}
