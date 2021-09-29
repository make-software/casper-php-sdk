<?php

namespace Casper\Entity;

class Account
{
    private string $accountHash;

    private string $mainPurse;

    /**
     * @var NamedKey[]
     */
    private array $namedKeys;

    /**
     * @var AssociatedKey[]
     */
    private array $associatedKeys;

    private ActionThresholds $actionThresholds;

    /**
     * @param string $accountHash
     * @param string $mainPurse
     * @param NamedKey[] $namedKeys
     * @param AssociatedKey[] $associatedKeys
     * @param ActionThresholds $actionThresholds
     */
    public function __construct(
        string $accountHash,
        string $mainPurse,
        array $namedKeys,
        array $associatedKeys,
        ActionThresholds $actionThresholds
    ) {
        $this->accountHash = $accountHash;
        $this->mainPurse = $mainPurse;
        $this->namedKeys = $namedKeys;
        $this->associatedKeys = $associatedKeys;
        $this->actionThresholds = $actionThresholds;
    }

    public function getAccountHash(): string
    {
        return $this->accountHash;
    }

    public function getMainPurse(): string
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
