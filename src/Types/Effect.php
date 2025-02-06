<?php

namespace Casper\Types;

class Effect
{
    /**
     * @var Operation[]
     */
    private array $operations;

    /**
     * @var Transform[]
     */
    private array $transforms;

    public function __construct(array $operations, array $transforms)
    {
        $this->operations = $operations;
        $this->transforms = $transforms;
    }

    public function getOperations(): array
    {
        return $this->operations;
    }

    public function getTransforms(): array
    {
        return $this->transforms;
    }
}
