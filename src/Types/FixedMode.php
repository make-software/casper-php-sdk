<?php

namespace Casper\Types;

class FixedMode
{
    private \GMP $gasPriceTolerance;

    private int $additionalComputationFactor;

    public function __construct(\GMP $gasPriceTolerance, int $additionalComputationFactor)
    {
        $this->gasPriceTolerance = $gasPriceTolerance;
        $this->additionalComputationFactor = $additionalComputationFactor;
    }

    public function getGasPriceTolerance(): \GMP
    {
        return $this->gasPriceTolerance;
    }

    public function getAdditionalComputationFactor(): int
    {
        return $this->additionalComputationFactor;
    }
}
