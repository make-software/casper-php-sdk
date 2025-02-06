<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLPublicKey;

class EraReport
{
    /**
     * @var CLPublicKey[]
     */
    private array $equivocators;

    /**
     * @var CLPublicKey[]
     */
    private array $inactiveValidators;

    /**
     * @var Reward[]
     */
    private array $rewards;

    public function __construct(array $equivocators, array $inactiveValidators, array $rewards)
    {
        $this->equivocators = $equivocators;
        $this->inactiveValidators = $inactiveValidators;
        $this->rewards = $rewards;
    }

    public function getEquivocators(): array
    {
        return $this->equivocators;
    }

    public function getInactiveValidators(): array
    {
        return $this->inactiveValidators;
    }

    public function getRewards(): array
    {
        return $this->rewards;
    }
}
