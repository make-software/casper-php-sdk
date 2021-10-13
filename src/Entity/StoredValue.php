<?php

namespace Casper\Entity;

use Casper\CLType\CLValue;

//TODO: Replace with key abstraction (https://docs.rs/casper-types/1.3.1/casper_types/enum.Key.html)
class StoredValue
{
    private ?CLValue $cLValue;

    private ?Account $account;

    private ?string $contractWASM;

    private ?Contract $contract;

    private ?ContractPackage $contractPackage;

    private ?Transfer $transfer;

    private ?DeployInfo $deployInfo;

    private ?EraInfo $eraInfo;

    public function __construct(
        ?CLValue         $cLValue,
        ?Account         $account,
        ?string          $contractWASM,
        ?Contract        $contract,
        ?ContractPackage $contractPackage,
        ?Transfer        $transfer,
        ?DeployInfo      $deployInfo,
        ?EraInfo         $eraInfo
    )
    {
        $this->cLValue = $cLValue;
        $this->account = $account;
        $this->contractWASM = $contractWASM;
        $this->contract = $contract;
        $this->contractPackage = $contractPackage;
        $this->transfer = $transfer;
        $this->deployInfo = $deployInfo;
        $this->eraInfo = $eraInfo;
    }

    public function getCLValue(): ?CLValue
    {
        return $this->cLValue;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function getContractWASM(): ?string
    {
        return $this->contractWASM;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function getContractPackage(): ?ContractPackage
    {
        return $this->contractPackage;
    }

    public function getTransfer(): ?Transfer
    {
        return $this->transfer;
    }

    public function getDeployInfo(): ?DeployInfo
    {
        return $this->deployInfo;
    }

    public function getEraInfo(): ?EraInfo
    {
        return $this->eraInfo;
    }
}
