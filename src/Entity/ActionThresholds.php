<?php

namespace Casper\Entity;

class ActionThresholds
{
    private int $deployment;

    private int $keyManagement;

    public function __construct(int $deployment, int $keyManagement)
    {
        $this->deployment = $deployment;
        $this->keyManagement = $keyManagement;
    }

    public function getDeployment(): int
    {
        return $this->deployment;
    }

    public function getKeyManagement(): int
    {
        return $this->keyManagement;
    }
}
