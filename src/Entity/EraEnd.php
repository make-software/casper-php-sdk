<?php

namespace Casper\Entity;

class EraEnd
{
    private EraReport $eraReport;

    /**
     * @var ValidatorWeight[]
     */
    private array $nextEraValidatorWeights;

    public function __construct(EraReport $eraReport, array $nextEraValidatorWeights)
    {
        $this->eraReport = $eraReport;
        $this->nextEraValidatorWeights = $nextEraValidatorWeights;
    }

    public function getEraReport(): EraReport
    {
        return $this->eraReport;
    }

    public function getNextEraValidatorWeights(): array
    {
        return $this->nextEraValidatorWeights;
    }
}
