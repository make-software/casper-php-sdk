<?php

namespace Casper\Types;

use Casper\Types\CLValue\CLAccountHash;
use Casper\Types\CLValue\CLURef;

class Account
{
    private CLAccountHash $accountHash;

    private CLURef $mainPurse;

    private array $namedKeys;

    /**
     * @var AssociatedKey[]
     */
    private array $associatedKeys;

    private ActionThresholds $actionThresholds;

    public function __construct(
        CLAccountHash $accountHash,
        CLURef $mainPurse,
        array $namedKeys,
        array $associatedKeys,
        ActionThresholds $actionThresholds
    )
    {
        $this->accountHash = $accountHash;
        $this->mainPurse = $mainPurse;
        $this->namedKeys = $namedKeys;
        $this->associatedKeys = $associatedKeys;
        $this->actionThresholds = $actionThresholds;
    }

    public function getAccountHash(): CLAccountHash
    {
        return $this->accountHash;
    }

    public function getMainPurse(): CLURef
    {
        return $this->mainPurse;
    }

    public function getNamedKeys(): array
    {
        return $this->namedKeys;
    }

    public function getAssociatedKeys(): array
    {
        return $this->associatedKeys;
    }

    public function getActionThresholds(): ActionThresholds
    {
        return $this->actionThresholds;
    }
}
