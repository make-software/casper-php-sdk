<?php

namespace Casper\Types;

use Casper\Util\ByteUtil;

class Transaction
{
    const ENTRY_POINT_CUSTOM = 'Custom';
    const ENTRY_POINT_TRANSFER = 'Transfer';
    const ENTRY_POINT_ADD_BID = 'AddBid';
    const ENTRY_POINT_WITHDRAW_BID = 'WithdrawBid';
    const ENTRY_POINT_DELEGATE = 'Delegate';
    const ENTRY_POINT_UNDELEGATE = 'Undelegate';
    const ENTRY_POINT_REDELEGATE = 'Redelegate';
    const ENTRY_POINT_ACTIVATE_BID = 'ActivateBid';
    const ENTRY_POINT_CHANGE_BID_PUBLIC_KEY = 'ChangeBidPublicKey';
    const ENTRY_POINT_CALL = 'Call';
    const ENTRY_POINT_ADD_RESERVATIONS = 'AddReservations';
    const ENTRY_POINT_CANCEL_RESERVATIONS = 'CancelReservations';

    private string $hash;

    private string $chainName;

    private int $timestamp;

    private int $ttl;

    private InitiatorAddr $initiatorAddr;

    private PricingMode $pricingMode;

    /**
     * @var NamedArg[]
     */
    private array $args;

    private TransactionTarget $target;

    private string $entryPoint;

    private string $scheduling;

    /**
     * @var Approval[]
     */
    private array $approvals;

    private ?Deploy $originDeployV1;

    private ?TransactionV1 $originTransactionV1;

    public static function newTransactionFromTransactionV1(TransactionV1 $transactionV1): self
    {
        return new self(
            $transactionV1->getHash(),
            $transactionV1->getPayload()->getChainName(),
            $transactionV1->getPayload()->getTimestamp(),
            $transactionV1->getPayload()->getTtl(),
            $transactionV1->getPayload()->getInitiatorAddr(),
            $transactionV1->getPayload()->getPricingMode(),
            $transactionV1->getPayload()->getFields()->getArgs(),
            $transactionV1->getPayload()->getFields()->getTarget(),
            $transactionV1->getPayload()->getFields()->getEntryPoint(),
            $transactionV1->getPayload()->getFields()->getScheduling(),
            $transactionV1->getApprovals(),
            null,
            $transactionV1
        );
    }

    public static function newTransactionFromDeploy(Deploy $deploy): self
    {
        if ($deploy->isTransfer()) {
            $transactionEntryPoint = self::ENTRY_POINT_TRANSFER;
        }
        else if ($deploy->isModuleBytes()) {
            $transactionEntryPoint = self::ENTRY_POINT_CALL;
        }
        else if ($deploy->getSession() instanceof DeployExecutableStoredContractByHash
            || $deploy->getSession() instanceof DeployExecutableStoredContractByName) {
            $transactionEntryPoint = $deploy->getSession()->getEntryPoint();
        }
        else {
            $transactionEntryPoint = self::ENTRY_POINT_CUSTOM;
        }

        $paymentAmount = 0;
        $paymentArgs = $deploy->getPayment()->getArgs();
        foreach ($paymentArgs as $paymentArg) {
            if ($paymentArg->getName() === 'amount') {
                $paymentAmount = $paymentArg->getValue()->parsedValue();
            }
        }
        $standardPayment = $paymentAmount === 0 && $deploy->isModuleBytes();
        $gasPriceTolerance = 1;

        $pricingMode = new PricingMode(
            new PaymentLimitedMode(
                gmp_init($paymentAmount),
                gmp_init($gasPriceTolerance),
                $standardPayment
            ),
            null,
            null
        );

        return new Transaction(
            ByteUtil::byteArrayToHex($deploy->getHash()),
            $deploy->getHeader()->getChainName(),
            $deploy->getHeader()->getTimestamp(),
            $deploy->getHeader()->getTtl(),
            new InitiatorAddr($deploy->getHeader()->getPublicKey(), null),
            $pricingMode,
            $deploy->getSession()->getArgs(),
            TransactionTarget::newTransactionTargetFromSession($deploy->getSession()),
            $transactionEntryPoint,
            '',
            $deploy->getApprovals(),
            $deploy,
            null
        );
    }

    public function __construct(
        string $hash,
        string $chainName,
        int $timestamp,
        int $ttl,
        InitiatorAddr $initiatorAddr,
        PricingMode $pricingMode,
        array $args,
        TransactionTarget $target,
        string $entryPoint,
        string $scheduling,
        array $approvals = [],
        ?Deploy $originDeployV1 = null,
        ?TransactionV1 $originTransactionV1 = null
    )
    {
        $this->hash = $hash;
        $this->chainName = $chainName;
        $this->timestamp = $timestamp;
        $this->ttl = $ttl;
        $this->initiatorAddr = $initiatorAddr;
        $this->pricingMode = $pricingMode;
        $this->args = $args;
        $this->target = $target;
        $this->entryPoint = $entryPoint;
        $this->scheduling = $scheduling;
        $this->approvals = $approvals;
        $this->originDeployV1 = $originDeployV1;
        $this->originTransactionV1 = $originTransactionV1;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getChainName(): string
    {
        return $this->chainName;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function getTtl(): int
    {
        return $this->ttl;
    }

    public function getInitiatorAddr(): InitiatorAddr
    {
        return $this->initiatorAddr;
    }

    public function getPricingMode(): PricingMode
    {
        return $this->pricingMode;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function getTarget(): TransactionTarget
    {
        return $this->target;
    }

    public function getEntryPoint(): string
    {
        return $this->entryPoint;
    }

    public function getScheduling(): string
    {
        return $this->scheduling;
    }

    public function getApprovals(): array
    {
        return $this->approvals;
    }

    public function getOriginDeployV1(): ?Deploy
    {
        return $this->originDeployV1;
    }

    public function getOriginTransactionV1(): ?TransactionV1
    {
        return $this->originTransactionV1;
    }
}
