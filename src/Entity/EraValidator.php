<?php

namespace Casper\Entity;

class EraValidator
{
    private int $eraId;

    /**
     * @var ValidatorWeight[]
     */
    private array $validatorWeights;

    /**
     * @param int $eraId
     * @param ValidatorWeight[] $validatorWeights
     */
    public function __construct(int $eraId, array $validatorWeights)
    {
        $this->eraId = $eraId;
        $this->validatorWeights = $validatorWeights;
    }

    public function getEraId(): int
    {
        return $this->eraId;
    }

    /**
     * @return ValidatorWeight[]
     */
    public function getValidatorWeights(): array
    {
        return $this->validatorWeights;
    }
}
