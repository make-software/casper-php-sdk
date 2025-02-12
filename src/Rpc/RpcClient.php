<?php

namespace Casper\Rpc;

use Casper\Rpc\ResultTypes\ChainGetBlockResult;
use Casper\Rpc\ResultTypes\ChainGetBlockResultV1Compatible;
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
use Casper\Rpc\ResultTypes\InfoGetTransactionResultV1Compatible;
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
use Casper\Types\Serializer\DeploySerializer;
use Casper\Types\Serializer\TransactionSerializer;
use Casper\Types\Transaction;

/**
 * Class for interacting with the network via RPC
 */
class RpcClient implements Client
{
    private const RPC_METHOD_INFO_GET_DEPLOY = 'info_get_deploy';
    private const RPC_METHOD_INFO_GET_TRANSACTION = 'info_get_transaction';

    private const RPC_METHOD_ACCOUNT_PUT_DEPLOY = 'account_put_deploy';
    private const RPC_METHOD_ACCOUNT_PUT_TRANSACTION = 'account_put_transaction';
    private const RPC_METHOD_CHAIN_GET_BLOCK = 'chain_get_block';
    private const RPC_METHOD_INFO_GET_PEERS = 'info_get_peers';
    private const RPC_METHOD_INFO_GET_STATUS = 'info_get_status';
    private const RPC_METHOD_STATE_GET_AUCTION_INFO = 'state_get_auction_info';
    private const RPC_METHOD_CHAIN_GET_STATE_ROOT_HASH = 'chain_get_state_root_hash';
    private const RPC_METHOD_STATE_GET_ITEM = 'state_get_item';
    private const RPC_METHOD_CHAIN_GET_BLOCK_TRANSFERS = 'chain_get_block_transfers';
    private const RPC_METHOD_STATE_GET_ACCOUNT_INFO = 'state_get_account_info';
    private const RPC_METHOD_STATE_GET_BALANCE = 'state_get_balance';
    private const RPC_METHOD_CHAIN_GET_ERA_INFO_BY_SWITCH_BLOCK = 'chain_get_era_info_by_switch_block';
    private const RPC_METHOD_STATE_GET_DICTIONARY_ITEM = 'state_get_dictionary_item';
    private const RPC_METHOD_QUERY_GLOBAL_STATE = 'query_global_state';
    private const RPC_METHOD_QUERY_BALANCE = 'query_balance';
    private const RPC_METHOD_QUERY_BALANCE_DETAILS = 'query_balance_details';
    private const RPC_METHOD_INFO_GET_CHAINSPEC = 'info_get_chainspec';
    private const RPC_METHOD_INFO_GET_VALIDATOR_CHANGES = 'info_get_validator_changes';
    private const RPC_METHOD_STATE_GET_ENTITY = 'state_get_entity';
    private const RPC_METHOD_CHAIN_GET_ERA_SUMMARY = 'chain_get_era_summary';
    private const RPC_METHOD_INFO_GET_REWARD = 'info_get_reward';

    public const PURSE_IDENTIFIER_TYPE_UREF = 'purse_uref';
    public const PURSE_IDENTIFIER_TYPE_MAIN_PURSE_UNDER_PUBLIC_KEY = 'main_purse_under_public_key';
    public const PURSE_IDENTIFIER_TYPE_MAIN_PURSE_UNDER_ACCOUNT_HASH = 'main_purse_under_account_hash';

    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws RpcError
     */
    public function getLatestAuctionInfo(): StateGetAuctionInfoResult
    {
        return StateGetAuctionInfoResult::fromJSON(
            $this->processRequest(self::RPC_METHOD_STATE_GET_AUCTION_INFO)
        );
    }

    /**
     * @throws RpcError
     */
    public function getAuctionInfoByHash(string $blockHash): StateGetAuctionInfoResult
    {
        return StateGetAuctionInfoResult::fromJSON(
            $this->processRequest(self::RPC_METHOD_STATE_GET_AUCTION_INFO, array(
                'block_identifier' => array(
                    'Hash' => $blockHash
                )
            ))
        );
    }

    /**
     * @throws RpcError
     */
    public function getAuctionInfoByHeight(int $blockHeight): StateGetAuctionInfoResult
    {
        return StateGetAuctionInfoResult::fromJSON(
            $this->processRequest(self::RPC_METHOD_STATE_GET_AUCTION_INFO, array(
                'block_identifier' => array(
                    'Height' => $blockHeight
                )
            ))
        );
    }

    /**
     * @throws RpcError
     */
    public function getEraInfoLatest(): ChainGetEraInfoResult
    {
        return ChainGetEraInfoResult::fromJSON(
            $this->processRequest(self::RPC_METHOD_CHAIN_GET_ERA_INFO_BY_SWITCH_BLOCK)
        );
    }

    /**
     * @throws RpcError
     */
    public function getEraInfoByBlockHash(string $blockHash): ChainGetEraInfoResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_CHAIN_GET_ERA_INFO_BY_SWITCH_BLOCK,
            array(
                'block_identifier' => array(
                    'Hash' => $blockHash
                )
            )
        );

        return ChainGetEraInfoResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getEraInfoByBlockHeight(int $blockHeight): ChainGetEraInfoResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_CHAIN_GET_ERA_INFO_BY_SWITCH_BLOCK,
            array(
                'block_identifier' => array(
                    'Height' => $blockHeight
                )
            )
        );

        return ChainGetEraInfoResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function GetValidatorChangesInfo(): InfoGetValidatorChangesResult
    {
        return InfoGetValidatorChangesResult::fromJson(
            $this->processRequest(self::RPC_METHOD_INFO_GET_VALIDATOR_CHANGES)
        );
    }

    /**
     * @throws RpcError
     */
    public function getLatestBalance(string $purseURef): StateGetBalanceResult
    {
        return self::getBalanceByStateRootHash(
            $purseURef,
            self::getStateRootHashLatest()->getStateRootHash()
        );
    }

    /**
     * @throws RpcError
     */
    public function getBalanceByStateRootHash(string $purseURef, string $stateRootHash): StateGetBalanceResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_STATE_GET_BALANCE,
            array(
                'state_root_hash' => $stateRootHash,
                'purse_uref' => $purseURef,
            )
        );

        return StateGetBalanceResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     * @throws \Exception
     */
    public function getDeploy(string $deployHash): InfoGetDeployResult
    {
        $result = $this->processRequest(self::RPC_METHOD_INFO_GET_DEPLOY, array(
            'deploy_hash' => $deployHash
        ));

        return InfoGetDeployResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     * @throws \Exception
     */
    public function getDeployFinalizedApproval(string $deployHash): InfoGetDeployResult
    {
        $result = $this->processRequest(self::RPC_METHOD_INFO_GET_DEPLOY, array(
            'deploy_hash' => $deployHash,
            'finalized_approvals' => true
        ));

        return InfoGetDeployResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     * @throws \Exception
     */
    public function getTransactionByTransactionHash(string $transactionHash): InfoGetTransactionResult
    {
        $result = $this->processRequest(self::RPC_METHOD_INFO_GET_TRANSACTION, array(
            'transaction_hash' => array(
                'Version1' => $transactionHash
            )
        ));

        return InfoGetTransactionResult::fromInfoGetTransactionResultV1Compatible(
            InfoGetTransactionResultV1Compatible::fromJSON($result)
        );
    }

    /**
     * @throws RpcError
     * @throws \Exception
     */
    public function getTransactionByDeployHash(string $deployHash): InfoGetTransactionResult
    {
        $result = $this->processRequest(self::RPC_METHOD_INFO_GET_TRANSACTION, array(
            'transaction_hash' => array(
                'Deploy' => $deployHash
            )
        ));

        return InfoGetTransactionResult::fromInfoGetTransactionResultV1Compatible(
            InfoGetTransactionResultV1Compatible::fromJSON($result)
        );
    }

    /**
     * @throws RpcError
     * @throws \Exception
     */
    public function getTransactionFinalizedApprovalByTransactionHash(string $transactionHash): InfoGetTransactionResult
    {
        $result = $this->processRequest(self::RPC_METHOD_INFO_GET_TRANSACTION, array(
            'transaction_hash' => array(
                'Version1' => $transactionHash
            ),
            'finalized_approvals' => true
        ));

        return InfoGetTransactionResult::fromInfoGetTransactionResultV1Compatible(
            InfoGetTransactionResultV1Compatible::fromJSON($result)
        );
    }

    /**
     * @throws RpcError
     * @throws \Exception
     */
    public function getTransactionFinalizedApprovalByDeployHash(string $deployHash): InfoGetTransactionResult
    {
        $result = $this->processRequest(self::RPC_METHOD_INFO_GET_TRANSACTION, array(
            'transaction_hash' => array(
                'Deploy' => $deployHash
            ),
            'finalized_approvals' => true
        ));

        return InfoGetTransactionResult::fromInfoGetTransactionResultV1Compatible(
            InfoGetTransactionResultV1Compatible::fromJSON($result)
        );
    }

    /**
     * @throws \Exception
     */
    public function getDictionaryItemByURef(
        string $stateRootHash,
        string $dictionaryItemKey,
        string $seedUref
    ): StateGetDictionaryResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_STATE_GET_DICTIONARY_ITEM,
            array(
                'state_root_hash' => $stateRootHash,
                'dictionary_identifier' => array(
                    'URef' => array(
                        'seed_uref' => $seedUref,
                        'dictionary_item_key' => $dictionaryItemKey,
                    )
                )
            )
        );

        return StateGetDictionaryResult::fromJSON($result);
    }

    /**
     * @throws \Exception
     */
    public function getDictionaryItemByContractNamedKey(
        string $stateRootHash,
        string $dictionaryItemKey,
        string $dictionaryName
    ): StateGetDictionaryResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_STATE_GET_DICTIONARY_ITEM,
            array(
                'state_root_hash' => $stateRootHash,
                'dictionary_identifier' => array(
                    'ContractNamedKey' => array(
                        'dictionary_name' => $dictionaryName,
                        'dictionary_item_key' => $dictionaryItemKey,
                    )
                )
            )
        );

        return StateGetDictionaryResult::fromJSON($result);
    }

    /**
     * @throws \Exception
     */
    public function getDictionaryItemByAccountNamedKey(
        string $stateRootHash,
        string $dictionaryItemKey,
        string $dictionaryName
    ): StateGetDictionaryResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_STATE_GET_DICTIONARY_ITEM,
            array(
                'state_root_hash' => $stateRootHash,
                'dictionary_identifier' => array(
                    'AccountNamedKey' => array(
                        'dictionary_name' => $dictionaryName,
                        'dictionary_item_key' => $dictionaryItemKey,
                    )
                )
            )
        );

        return StateGetDictionaryResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     * @throws \Exception
     */
    public function getStateItem(string $stateRootHash, string $key, array $path = []): StateGetItemResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_STATE_GET_ITEM,
            array(
                'state_root_hash' => $stateRootHash,
                'key' => $key,
                'path' => $path,
            )
        );

        return StateGetItemResult::fromJson($result);
    }

    /**
     * @throws RpcError
     */
    public function queryLatestGlobalState(string $key, array $path = []): QueryGlobalStateResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_GLOBAL_STATE,
            array(
                'key' => $key,
                'path' => $path,
            )
        );

        return QueryGlobalStateResult::fromJson($result);
    }

    /**
     * @throws RpcError
     */
    public function queryGlobalStateByBlockHash(string $blockHash, string $key, array $path = []): QueryGlobalStateResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_GLOBAL_STATE,
            array(
                'state_identifier' => array(
                    'BlockHash' => $blockHash
                ),
                'key' => $key,
                'path' => $path,
            )
        );

        return QueryGlobalStateResult::fromJson($result);
    }

    /**
     * @throws RpcError
     */
    public function queryGlobalStateByBlockHeight(int $blockHeight, string $key, array $path = []): QueryGlobalStateResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_GLOBAL_STATE,
            array(
                'state_identifier' => array(
                    'BlockHeight' => $blockHeight
                ),
                'key' => $key,
                'path' => $path,
            )
        );

        return QueryGlobalStateResult::fromJson($result);
    }

    /**
     * @throws RpcError
     */
    public function queryGlobalStateByStateRootHash(string $stateRootHash, string $key, array $path = []): QueryGlobalStateResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_GLOBAL_STATE,
            array(
                'state_identifier' => array(
                    'StateRootHash' => $stateRootHash
                ),
                'key' => $key,
                'path' => $path,
            )
        );

        return QueryGlobalStateResult::fromJson($result);
    }

    /**
     * @throws RpcError
     */
    public function getAccountInfoByBlockHash(string $blockHash, CLPublicKey $publicKey): StateGetAccountInfoResult
    {
        $result = $this->processRequest(self::RPC_METHOD_STATE_GET_ACCOUNT_INFO, array(
            'block_identifier' => array(
                'Hash' => $blockHash
            ),
            'public_key' => $publicKey->toHex(),
        ));

        return StateGetAccountInfoResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getAccountInfoByBlockHeight(int $blockHeight, CLPublicKey $publicKey): StateGetAccountInfoResult
    {
        $result = $this->processRequest(self::RPC_METHOD_STATE_GET_ACCOUNT_INFO, array(
            'block_identifier' => array(
                'Height' => $blockHeight
            ),
            'public_key' => $publicKey->toHex(),
        ));

        return StateGetAccountInfoResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getEntityByAccountHashAndBlockHash(CLAccountHash $accountHash, string $blockHash): StateGetEntityResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_STATE_GET_ENTITY,
            array(
                'entity_identifier' => array(
                    'AccountHash' => $accountHash->parsedValue(),
                ),
                'block_identifier' => array(
                    'Hash' => $blockHash,
                )
            )
        );

        return StateGetEntityResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getEntityByAccountHashAndBlockHeight(CLAccountHash $accountHash, int $blockHeight): StateGetEntityResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_STATE_GET_ENTITY,
            array(
                'entity_identifier' => array(
                    'AccountHash' => $accountHash->parsedValue(),
                ),
                'block_identifier' => array(
                    'Height' => $blockHeight,
                )
            )
        );

        return StateGetEntityResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getEntityByPublicKeyAndBlockHash(CLPublicKey $publicKey, string $blockHash): StateGetEntityResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_STATE_GET_ENTITY,
            array(
                'entity_identifier' => array(
                    'PublicKey' => $publicKey->parsedValue(),
                ),
                'block_identifier' => array(
                    'Hash' => $blockHash,
                )
            )
        );

        return StateGetEntityResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getEntityByPublicKeyAndBlockHeight(CLPublicKey $publicKey, int $blockHeight): StateGetEntityResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_STATE_GET_ENTITY,
            array(
                'entity_identifier' => array(
                    'PublicKey' => $publicKey->parsedValue(),
                ),
                'block_identifier' => array(
                    'Height' => $blockHeight,
                )
            )
        );

        return StateGetEntityResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     * @throws \Exception
     */
    public function getLatestBlock(): ChainGetBlockResult
    {
        return ChainGetBlockResult::fromChainGetBlockResultV1Compatible(
            ChainGetBlockResultV1Compatible::fromJSON(
                $this->processRequest(self::RPC_METHOD_CHAIN_GET_BLOCK)
            )
        );
    }

    /**
     * @throws RpcError
     * @throws \Exception
     */
    public function getBlockByHash(string $blockHash): ChainGetBlockResult
    {
        $result = $this->processRequest(self::RPC_METHOD_CHAIN_GET_BLOCK, array(
            'block_identifier' => array(
                'Hash' => $blockHash
            )
        ));

        return ChainGetBlockResult::fromChainGetBlockResultV1Compatible(
            ChainGetBlockResultV1Compatible::fromJSON($result)
        );
    }

    /**
     * @throws RpcError
     * @throws \Exception
     */
    public function getBlockByHeight(int $blockHeight): ChainGetBlockResult
    {
        $result = $this->processRequest(self::RPC_METHOD_CHAIN_GET_BLOCK, array(
            'block_identifier' => array(
                'Height' => $blockHeight
            )
        ));

        return ChainGetBlockResult::fromChainGetBlockResultV1Compatible(
            ChainGetBlockResultV1Compatible::fromJSON($result)
        );
    }

    /**
     * @throws RpcError
     */
    public function getLatestBlockTransfers(): ChainGetBlockTransfersResult
    {
        return ChainGetBlockTransfersResult::fromJSON(
            $this->processRequest(self::RPC_METHOD_CHAIN_GET_BLOCK_TRANSFERS)
        );
    }

    /**
     * @throws RpcError
     */
    public function getBlockTransfersByHash(string $blockHash = null): ChainGetBlockTransfersResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_CHAIN_GET_BLOCK_TRANSFERS,
            array(
                'block_identifier' => array(
                    'Hash' => $blockHash
                )
            )
        );

        return ChainGetBlockTransfersResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getBlockTransfersByHeight(int $blockHeight = null): ChainGetBlockTransfersResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_CHAIN_GET_BLOCK_TRANSFERS,
            array(
                'block_identifier' => array(
                    'Height' => $blockHeight
                )
            )
        );

        return ChainGetBlockTransfersResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getEraSummaryLatest(): ChainGetEraSummaryResult
    {
        return ChainGetEraSummaryResult::fromJSON(
            $this->processRequest(self::RPC_METHOD_CHAIN_GET_ERA_SUMMARY)
        );
    }

    /**
     * @throws RpcError
     */
    public function getEraSummaryByHash(string $blockHash): ChainGetEraSummaryResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_CHAIN_GET_ERA_SUMMARY,
            array(
                'block_identifier' => array(
                    'Hash' => $blockHash
                )
            )
        );

        return ChainGetEraSummaryResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getEraSummaryByHeight(int $blockHeight): ChainGetEraSummaryResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_CHAIN_GET_ERA_SUMMARY,
            array(
                'block_identifier' => array(
                    'Height' => $blockHeight
                )
            )
        );

        return ChainGetEraSummaryResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getStateRootHashLatest(): ChainGetStateRootHashResult
    {
        return ChainGetStateRootHashResult::fromJSON(
            $this->processRequest(self::RPC_METHOD_CHAIN_GET_STATE_ROOT_HASH)
        );
    }

    /**
     * @throws RpcError
     */
    public function getStateRootHashByHash(string $blockHash): ChainGetStateRootHashResult
    {
        $result = $this->processRequest(self::RPC_METHOD_CHAIN_GET_STATE_ROOT_HASH, array(
            'block_identifier' => array(
                'Hash' => $blockHash
            )
        ));

        return ChainGetStateRootHashResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getStateRootHashByHeight(int $blockHeight): ChainGetStateRootHashResult
    {
        $result = $this->processRequest(self::RPC_METHOD_CHAIN_GET_STATE_ROOT_HASH, array(
            'block_identifier' => array(
                'Height' => $blockHeight
            )
        ));

        return ChainGetStateRootHashResult::fromJSON($result);
    }

    /**
     * @throws \Exception
     */
    public function getStatus(): InfoGetStatusResult
    {
        return InfoGetStatusResult::fromJSON(
            $this->processRequest(self::RPC_METHOD_INFO_GET_STATUS)
        );
    }

    /**
     * @throws RpcError
     */
    public function getPeers(): InfoGetPeerResult
    {
        return InfoGetPeerResult::fromJSON(
            $this->processRequest(self::RPC_METHOD_INFO_GET_PEERS)
        );
    }

    /**
     * @throws RpcError
     */
    public function queryLatestBalance(string $purseIdentifierType, string $purseIdentifier): QueryBalanceResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_BALANCE_DETAILS,
            array(
                'purse_identifier' => array(
                    $purseIdentifierType => $purseIdentifier
                )
            )
        );

        return QueryBalanceResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function queryBalanceByBlockHeight(
        string $purseIdentifierType,
        string $purseIdentifier,
        int $blockHeight
    ): QueryBalanceResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_BALANCE,
            array(
                'purse_identifier' => array(
                    $purseIdentifierType => $purseIdentifier
                ),
                'state_identifier' => array(
                    'BlockHeight' => $blockHeight
                )
            )
        );

        return QueryBalanceResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function queryBalanceByBlockHash(
        string $purseIdentifierType,
        string $purseIdentifier,
        string $blockHash
    ): QueryBalanceResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_BALANCE,
            array(
                'purse_identifier' => array(
                    $purseIdentifierType => $purseIdentifier
                ),
                'state_identifier' => array(
                    'BlockHash' => $blockHash
                )
            )
        );

        return QueryBalanceResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function queryBalanceByStateRootHash(
        string $purseIdentifierType,
        string $purseIdentifier,
        string $stateRootHash
    ): QueryBalanceResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_BALANCE,
            array(
                'purse_identifier' => array(
                    $purseIdentifierType => $purseIdentifier
                ),
                'state_identifier' => array(
                    'StateRootHash' => $stateRootHash
                )
            )
        );

        return QueryBalanceResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function queryLatestBalanceDetails(
        string $purseIdentifierType,
        string $purseIdentifier
    ): QueryBalanceDetailsResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_BALANCE_DETAILS,
            array(
                'purse_identifier' => array(
                    $purseIdentifierType => $purseIdentifier
                ),
            )
        );

        return QueryBalanceDetailsResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function queryBalanceDetailsByBlockHash(
        string $purseIdentifierType,
        string $purseIdentifier,
        string $blockHash
    ): QueryBalanceDetailsResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_BALANCE_DETAILS,
            array(
                'purse_identifier' => array(
                    $purseIdentifierType => $purseIdentifier
                ),
                'state_identifier' => array(
                    'BlockHash' => $blockHash
                )
            )
        );

        return QueryBalanceDetailsResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function queryBalanceDetailsByBlockHeight(
        string $purseIdentifierType,
        string $purseIdentifier,
        int $blockHeight
    ): QueryBalanceDetailsResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_BALANCE_DETAILS,
            array(
                'purse_identifier' => array(
                    $purseIdentifierType => $purseIdentifier
                ),
                'state_identifier' => array(
                    'BlockHeight' => $blockHeight
                )
            )
        );

        return QueryBalanceDetailsResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function queryBalanceDetailsByStateRootHash(
        string $purseIdentifierType,
        string $purseIdentifier,
        string $stateRootHash
    ): QueryBalanceDetailsResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_QUERY_BALANCE_DETAILS,
            array(
                'purse_identifier' => array(
                    $purseIdentifierType => $purseIdentifier
                ),
                'state_identifier' => array(
                    'StateRootHash' => $stateRootHash
                )
            )
        );

        return QueryBalanceDetailsResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getChainspec(): InfoGetChainspecResult
    {
        return InfoGetChainspecResult::fromJson(
            $this->processRequest(self::RPC_METHOD_INFO_GET_CHAINSPEC)
        );
    }

    /**
     * @throws RpcError
     */
    public function getLatestValidatorReward(CLPublicKey $validator): InfoGetRewardResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_INFO_GET_REWARD,
            array(
                'validator' => $validator->parsedValue()
            )
        );

        return InfoGetRewardResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getValidatorRewardByEraID(CLPublicKey $validator, int $eraID): InfoGetRewardResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_INFO_GET_REWARD,
            array(
                'validator' => $validator->parsedValue(),
                'era_identifier' => array(
                    'Era' => $eraID
                )
            )
        );

        return InfoGetRewardResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getValidatorRewardByBlockHash(CLPublicKey $validator, string $blockHash): InfoGetRewardResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_INFO_GET_REWARD,
            array(
                'validator' => $validator->parsedValue(),
                'era_identifier' => array(
                    'Block' => array(
                        'Hash' => $blockHash
                    )
                )
            )
        );

        return InfoGetRewardResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getValidatorRewardByBlockHeight(CLPublicKey $validator, int $blockHeight): InfoGetRewardResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_INFO_GET_REWARD,
            array(
                'validator' => $validator->parsedValue(),
                'era_identifier' => array(
                    'Block' => array(
                        'Height' => $blockHeight
                    )
                )
            )
        );

        return InfoGetRewardResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getLatestDelegatorReward(CLPublicKey $validator, CLPublicKey $delegator): InfoGetRewardResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_INFO_GET_REWARD,
            array(
                'validator' => $validator->parsedValue(),
                'delegator' => $delegator->parsedValue(),
            )
        );

        return InfoGetRewardResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getDelegatorRewardByEraID(
        CLPublicKey $validator,
        CLPublicKey $delegator,
        int $eraID
    ): InfoGetRewardResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_INFO_GET_REWARD,
            array(
                'validator' => $validator->parsedValue(),
                'delegator' => $delegator->parsedValue(),
                'era_identifier' => array(
                    'Era' => $eraID
                )
            )
        );

        return InfoGetRewardResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getDelegatorRewardByBlockHash(
        CLPublicKey $validator,
        CLPublicKey $delegator,
        string $blockHash
    ): InfoGetRewardResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_INFO_GET_REWARD,
            array(
                'validator' => $validator->parsedValue(),
                'delegator' => $delegator->parsedValue(),
                'era_identifier' => array(
                    'Block' => array(
                        'Hash' => $blockHash
                    )
                )
            )
        );

        return InfoGetRewardResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function getDelegatorRewardByBlockHeight(
        CLPublicKey $validator,
        CLPublicKey $delegator,
        int $blockHeight
    ): InfoGetRewardResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_INFO_GET_REWARD,
            array(
                'validator' => $validator->parsedValue(),
                'delegator' => $delegator->parsedValue(),
                'era_identifier' => array(
                    'Block' => array(
                        'Height' => $blockHeight
                    )
                )
            )
        );

        return InfoGetRewardResult::fromJSON($result);
    }

    // TODO: Complete putTransaction and putDeploy

    /**
     * @throws RpcError
     */
    public function putDeploy(Deploy $deploy): PutDeployResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_ACCOUNT_PUT_DEPLOY,
            array(
                'deploy' => DeploySerializer::toJson($deploy)
            )
        );

        return PutDeployResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    public function putTransaction(Transaction $transaction): PutTransactionResult
    {
        $result = $this->processRequest(
            self::RPC_METHOD_ACCOUNT_PUT_TRANSACTION,
            array(
                'transaction' => TransactionSerializer::toJson($transaction)
            )
        );

        return PutTransactionResult::fromJSON($result);
    }

    /**
     * @throws RpcError
     */
    private function processRequest(string $method, array $params = array()): ?array
    {
        $rpcResponse = $this->handler
            ->processCall(new RpcRequest($method, $params));

        if ($rpcResponse->getError()) {
            throw $rpcResponse->getError();
        }

        return $rpcResponse->getResult();
    }
}
