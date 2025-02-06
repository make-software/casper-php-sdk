<?php

namespace Casper\Types;

class EraInfo
{
    /**
     * @var SeigniorageAllocation[]
     */
    private array $seigniorageAllocations;

    /**
     * @param SeigniorageAllocation[] $seigniorageAllocations
     */
    public function __construct(array $seigniorageAllocations)
    {
        $this->seigniorageAllocations = $seigniorageAllocations;
    }

    /**
     * @return SeigniorageAllocation[]
     */
    public function getSeigniorageAllocations(): array
    {
        return $this->seigniorageAllocations;
    }
}
