<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\ExecutionInfo;
use Casper\Types\InitiatorAddr;
use Casper\Types\Transaction;

class InfoGetTransactionResult extends AbstractResult
{
    private Transaction $transaction;

    private ?ExecutionInfo $executionInfo;

    /**
     * @throws \Exception
     */
    public static function fromInfoGetTransactionResultV1Compatible(
        InfoGetTransactionResultV1Compatible $infoGetTransactionResultV1Compatible
    ): self
    {
        if ($infoGetTransactionResultV1Compatible->getTransaction()) {
            if ($transactionV1 = $infoGetTransactionResultV1Compatible->getTransaction()->getTransactionV1()) {
                return new self(
                    $infoGetTransactionResultV1Compatible->getRawJSON(),
                    Transaction::newTransactionFromTransactionV1($transactionV1),
                    $infoGetTransactionResultV1Compatible->getExecutionInfo()
                );
            }
            else if ($deploy = $infoGetTransactionResultV1Compatible->getTransaction()->getDeploy()) {
                return new self(
                    $infoGetTransactionResultV1Compatible->getRawJSON(),
                    Transaction::newTransactionFromDeploy($deploy),
                    $infoGetTransactionResultV1Compatible->getExecutionInfo()
                );
            }
        }
        else if ($infoGetTransactionResultV1Compatible->getDeploy()) {
            if ($infoGetTransactionResultV1Compatible->getExecutionResults()) {
                $executionInfo = ExecutionInfo::fromV1(
                    $infoGetTransactionResultV1Compatible->getExecutionResults(),
                    $infoGetTransactionResultV1Compatible->getBlockHeight(),
                    new InitiatorAddr($infoGetTransactionResultV1Compatible->getDeploy()->getHeader()->getPublicKey(), null)
                );
            }

            return new self(
                $infoGetTransactionResultV1Compatible->getRawJSON(),
                Transaction::newTransactionFromDeploy(
                    $infoGetTransactionResultV1Compatible->getDeploy()
                ),
                $executionInfo ?? $infoGetTransactionResultV1Compatible->getExecutionInfo()
            );
        }

        throw new \Exception('Incorrect RPC response structure');
    }

    public function __construct(
        array $rawJSON,
        Transaction $transaction,
        ?ExecutionInfo $executionInfo
    )
    {
        parent::__construct($rawJSON);
        $this->transaction = $transaction;
        $this->executionInfo = $executionInfo;
    }

    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    public function getExecutionInfo(): ?ExecutionInfo
    {
        return $this->executionInfo;
    }
}
