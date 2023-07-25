<?php

namespace Casper\Entity;

class SeigniorageAllocation
{
    private ?SeigniorageAllocationDelegator $delegator;

    private ?SeigniorageAllocationValidator $validator;

    public function __construct(?SeigniorageAllocationDelegator $delegator, ?SeigniorageAllocationValidator $validator)
    {
        $this->delegator = $delegator;
        $this->validator = $validator;
    }

    public function getDelegator(): ?SeigniorageAllocationDelegator
    {
        return $this->delegator;
    }

    public function getValidator(): ?SeigniorageAllocationValidator
    {
        return $this->validator;
    }
}
