<?php

namespace Casper\Entity;

use Casper\CLType\CLURef;

class ContractPackage
{
    private CLURef $accessKey;

    /**
     * @var ContractVersion[]
     */
    private array $contractVersions;

    /**
     * @var DisabledVersion[]
     */
    private array $disabledVersions;

    /**
     * @var Group[]
     */
    private array $groups;

    /**
     * @throws \Exception
     */
    public function __construct(CLURef $accessKey, array $contractVersions, array $disabledVersions, array $groups)
    {
        $this->accessKey = $accessKey;
        $this->contractVersions = $contractVersions;
        $this->disabledVersions = $disabledVersions;
        $this->groups = $groups;
    }

    public function getAccessKey(): CLURef
    {
        return $this->accessKey;
    }

    public function getContractVersions(): array
    {
        return $this->contractVersions;
    }

    public function getDisabledVersions(): array
    {
        return $this->disabledVersions;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }
}
