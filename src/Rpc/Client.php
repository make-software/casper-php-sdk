<?php

namespace Casper\Rpc;

use Casper\Rpc\ResultTypes\ChainGetBlockResult;
use Casper\Rpc\ResultTypes\ChainGetBlockTransfersResult;
use Casper\Rpc\ResultTypes\ChainGetEraInfoResult;
use Casper\Rpc\ResultTypes\ChainGetEraSummaryResult;
use Casper\Rpc\ResultTypes\ChainGetStateRootHashResult;
use Casper\Rpc\ResultTypes\InfoGetChainspecResult;
use Casper\Rpc\ResultTypes\InfoGetDeployResult;
use Casper\Rpc\ResultTypes\InfoGetPeerResult;
use Casper\Rpc\ResultTypes\InfoGetRewardResult;
use Casper\Rpc\ResultTypes\InfoGetStatusResult;
use Casper\Rpc\ResultTypes\InfoGetTransactionResult;
use Casper\Rpc\ResultTypes\InfoGetValidatorChangesResult;
use Casper\Rpc\ResultTypes\PutDeployResult;
use Casper\Rpc\ResultTypes\PutTransactionResult;
use Casper\Rpc\ResultTypes\QueryBalanceDetailsResult;
use Casper\Rpc\ResultTypes\QueryBalanceResult;
use Casper\Rpc\ResultTypes\QueryGlobalStateResult;
use Casper\Rpc\ResultTypes\StateGetAccountInfoResult;
use Casper\Rpc\ResultTypes\StateGetAuctionInfoResult;
use Casper\Rpc\ResultTypes\StateGetBalanceResult;
use Casper\Rpc\ResultTypes\StateGetDictionaryResult;
use Casper\Rpc\ResultTypes\StateGetEntityResult;
use Casper\Rpc\ResultTypes\StateGetItemResult;

use Casper\Types\CLValue\CLAccountHash;
use Casper\Types\CLValue\CLPublicKey;
use Casper\Types\Deploy;
use Casper\Types\Transaction;

interface Client
{
    // Proof-of-Stake RPCs
    public function getLatestAuctionInfo(): StateGetAuctionInfoResult;
    public function getAuctionInfoByHash(string $blockHash): StateGetAuctionInfoResult;
    public function getAuctionInfoByHeight(int $blockHeight): StateGetAuctionInfoResult;

    public function getEraInfoLatest(): ChainGetEraInfoResult;
    public function getEraInfoByBlockHash(string $blockHash): ChainGetEraInfoResult;
    public function getEraInfoByBlockHeight(int $blockHeight): ChainGetEraInfoResult;

    public function GetValidatorChangesInfo(): InfoGetValidatorChangesResult;

    // Informational RPCs
    public function getLatestBalance(string $purseURef): StateGetBalanceResult;
    public function getBalanceByStateRootHash(string $purseURef, string $stateRootHash): StateGetBalanceResult;
    public function getDeploy(string $deployHash): InfoGetDeployResult;
    public function getDeployFinalizedApproval(string $deployHash): InfoGetDeployResult;
    public function getTransactionByTransactionHash(string $transactionHash): InfoGetTransactionResult;
    public function getTransactionByDeployHash(string $deployHash): InfoGetTransactionResult;
    public function getTransactionFinalizedApprovalByTransactionHash(string $transactionHash): InfoGetTransactionResult;
    public function getTransactionFinalizedApprovalByDeployHash(string $deployHash): InfoGetTransactionResult;

    public function getDictionaryItemByURef(string $stateRootHash, string $dictionaryItemKey, string $seedUref): StateGetDictionaryResult;
    public function getDictionaryItemByContractNamedKey(string $stateRootHash, string $dictionaryItemKey, string $dictionaryName): StateGetDictionaryResult;
    public function getDictionaryItemByAccountNamedKey(string $stateRootHash, string $dictionaryItemKey, string $dictionaryName): StateGetDictionaryResult;
    public function getStateItem(string $stateRootHash, string $key, array $path): StateGetItemResult;

    public function queryLatestGlobalState(string $key, array $path): QueryGlobalStateResult;
    public function queryGlobalStateByBlockHash(string $blockHash, string $key, array $path): QueryGlobalStateResult;
    public function queryGlobalStateByBlockHeight(int $blockHeight, string $key, array $path): QueryGlobalStateResult;
    public function queryGlobalStateByStateRootHash(string $stateRootHash, string $key, array $path): QueryGlobalStateResult;

    public function getAccountInfoByBlockHash(string $blockHash, CLPublicKey $publicKey): StateGetAccountInfoResult;
    public function getAccountInfoByBlockHeight(int $blockHeight, CLPublicKey $publicKey): StateGetAccountInfoResult;

    public function getEntityByAccountHashAndBlockHash(CLAccountHash $accountHash, string $blockHash): StateGetEntityResult;
    public function getEntityByAccountHashAndBlockHeight(CLAccountHash $accountHash, int $blockHeight): StateGetEntityResult;
    public function getEntityByPublicKeyAndBlockHash(CLPublicKey $publicKey, string $blockHash): StateGetEntityResult;
    public function getEntityByPublicKeyAndBlockHeight(CLPublicKey $publicKey, int $blockHeight): StateGetEntityResult;

    public function getLatestBlock(): ChainGetBlockResult;
    public function getBlockByHash(string $blockHash): ChainGetBlockResult;
    public function getBlockByHeight(int $blockHeight): ChainGetBlockResult;

    public function getLatestBlockTransfers();
    public function getBlockTransfersByHash(string $blockHash): ChainGetBlockTransfersResult;
    public function getBlockTransfersByHeight(int $blockHeight): ChainGetBlockTransfersResult;

    public function getEraSummaryLatest(): ChainGetEraSummaryResult;
    public function getEraSummaryByHash(string $blockHash): ChainGetEraSummaryResult;
    public function getEraSummaryByHeight(int $blockHeight): ChainGetEraSummaryResult;

    public function getStateRootHashLatest(): ChainGetStateRootHashResult;
    public function getStateRootHashByHash(string $blockHash): ChainGetStateRootHashResult;
    public function getStateRootHashByHeight(int $blockHeight): ChainGetStateRootHashResult;

    public function getStatus(): InfoGetStatusResult;
    public function getPeers(): InfoGetPeerResult;

    public function queryLatestBalance(string $purseIdentifierType, string $purseIdentifier): QueryBalanceResult;
    public function queryBalanceByBlockHeight(string $purseIdentifierType, string $purseIdentifier, int $blockHeight): QueryBalanceResult;
    public function queryBalanceByBlockHash(string $purseIdentifierType, string $purseIdentifier, string $blockHash): QueryBalanceResult;
    public function queryBalanceByStateRootHash(string $purseIdentifierType, string $purseIdentifier, string $stateRootHash): QueryBalanceResult;

    public function queryLatestBalanceDetails(string $purseIdentifierType, string $purseIdentifier): QueryBalanceDetailsResult;
    public function queryBalanceDetailsByBlockHeight(string $purseIdentifierType, string $purseIdentifier, int $blockHeight): QueryBalanceDetailsResult;
    public function queryBalanceDetailsByBlockHash(string $purseIdentifierType, string $purseIdentifier, string $blockHash): QueryBalanceDetailsResult;
    public function queryBalanceDetailsByStateRootHash(string $purseIdentifierType, string $purseIdentifier, string $stateRootHash): QueryBalanceDetailsResult;

    public function getChainspec(): InfoGetChainspecResult;

    public function getLatestValidatorReward(CLPublicKey $validator): InfoGetRewardResult;
    public function getValidatorRewardByEraID(CLPublicKey $validator, int $eraID): InfoGetRewardResult;
    public function getValidatorRewardByBlockHash(CLPublicKey $validator, string $blockHash): InfoGetRewardResult;
    public function getValidatorRewardByBlockHeight(CLPublicKey $validator, int $blockHeight): InfoGetRewardResult;

    public function getLatestDelegatorReward(CLPublicKey $validator, CLPublicKey $delegator): InfoGetRewardResult;
    public function getDelegatorRewardByEraID(CLPublicKey $validator, CLPublicKey $delegator, int $eraID): InfoGetRewardResult;
    public function getDelegatorRewardByBlockHash(CLPublicKey $validator, CLPublicKey $delegator, string $blockHash): InfoGetRewardResult;
    public function getDelegatorRewardByBlockHeight(CLPublicKey $validator, CLPublicKey $delegator, int $blockHeight): InfoGetRewardResult;

    // Transactional RPCs
    public function putDeploy(Deploy $deploy): PutDeployResult;
    public function putTransaction(Transaction $transaction): PutTransactionResult;
}
