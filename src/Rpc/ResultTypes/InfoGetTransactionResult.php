<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\ExecutionInfo;
use Casper\Types\Serializer\ExecutionInfoSerializer;
use Casper\Types\Serializer\TransactionSerializer;
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

//        return new self(
//            $json['api_version'],
//            $json,
//            TransactionSerializer::fromJson($json['transaction']),
//            $json['execution_info'] ? ExecutionInfoSerializer::fromJson($json['execution_info']) : null
//        );
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
