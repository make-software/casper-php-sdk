<?php

namespace Casper\Entity;

use Casper\Validation\EntityValidationAware;

class ContractPackage
{
    use EntityValidationAware;

    private string $accessKey;

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
    public function __construct(string $accessKey, array $contractVersions, array $disabledVersions, array $groups)
    {
        $this->assertArrayContainsProperEntities($contractVersions, ContractVersion::class);
        $this->assertArrayContainsProperEntities($disabledVersions, DisabledVersion::class);
        $this->assertArrayContainsProperEntities($groups, Group::class);

        $this->accessKey = $accessKey;
        $this->contractVersions = $contractVersions;
        $this->disabledVersions = $disabledVersions;
        $this->groups = $groups;
    }

    public function getAccessKey(): string
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
