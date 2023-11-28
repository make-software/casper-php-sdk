<?php

namespace Casper\Rpc;

use Casper\Serializer\AccountSerializer;
use Casper\Serializer\AuctionStateSerializer;
use Casper\Serializer\ChainspecRegistryBytesSerializer;
use Casper\Serializer\CLAccountHashSerializer;
use Casper\Serializer\CLPublicKeySerializer;
use Casper\Serializer\CLURefSerializer;
use Casper\Serializer\DeployExecutionResultSerializer;
use Casper\Serializer\EraSummarySerializer;
use Casper\Serializer\GlobalStateSerializer;
use Casper\Serializer\PeerSerializer;
use Casper\Serializer\BlockSerializer;
use Casper\Serializer\DeploySerializer;
use Casper\Serializer\StatusSerializer;
use Casper\Serializer\StoredValueSerializer;
use Casper\Serializer\TransferSerializer;

use Casper\CLType\CLAccountHash;
use Casper\CLType\CLURef;
use Casper\CLType\CLPublicKey;

use Casper\Entity\Account;
use Casper\Entity\AuctionState;
use Casper\Entity\Block;
use Casper\Entity\ChainspecRegistryBytes;
use Casper\Entity\Deploy;
use Casper\Entity\DeployExecutionResult;
use Casper\Entity\EraSummary;
use Casper\Entity\GlobalState;
use Casper\Entity\Peer;
use Casper\Entity\Status;
use Casper\Entity\StoredValue;
use Casper\Entity\Transfer;

/**
 * Class for interacting with the network via RPC
 */
class RpcClient
{
    private const ID = 1;
    private const JSON_RPC = '2.0';

    private const RPC_METHOD_PUT_DEPLOY = 'account_put_deploy';
    private const RPC_METHOD_GET_DEPLOY_INFO = 'info_get_deploy';
    private const RPC_METHOD_GET_BLOCK_INFO = 'chain_get_block';
    private const RPC_METHOD_GET_PEERS = 'info_get_peers';
    private const RPC_METHOD_GET_STATUS = 'info_get_status';
    private const RPC_METHOD_GET_VALIDATORS_INFO = 'state_get_auction_info';
    private const RPC_METHOD_GET_STATE_ROOT_HASH = 'chain_get_state_root_hash';
    private const RPC_METHOD_GET_BLOCK_STATE = 'state_get_item';
    private const RPC_METHOD_GET_BLOCK_TRANSFERS = 'chain_get_block_transfers';
    private const RPC_METHOD_GET_ACCOUNT_INFO = 'state_get_account_info';
    private const RPC_METHOD_GET_ACCOUNT_BALANCE = 'state_get_balance';
    private const RPC_METHOD_GET_ERA_INFO_BY_SWITCH_BLOCK = 'chain_get_era_info_by_switch_block';
    private const RPC_METHOD_GET_DICTIONARY_ITEM = 'state_get_dictionary_item';
    private const RPC_METHOD_QUERY_GLOBAL_STATE = 'query_global_state';
    private const RPC_METHOD_SPECULATIVE_EXEC = 'speculative_exec';
    private const RPC_METHOD_QUERY_BALANCE = 'query_balance';
    private const RPC_METHOD_INFO_GET_CHAINSPEC = 'info_get_chainspec';

    public const PURSE_IDENTIFIER_TYPE_UREF = 'purse_uref';
    public const PURSE_IDENTIFIER_TYPE_MAIN_PURSE_UNDER_PUBLIC_KEY = 'main_purse_under_public_key';
    public const PURSE_IDENTIFIER_TYPE_MAIN_PURSE_UNDER_ACCOUNT_HASH = 'main_purse_under_account_hash';

    private string $nodeUrl;

    private ?string $bearerToken = null;

    private ?string $lastApiVersion = null;

    public function __construct(string $nodeUrl, string $bearerToken = null)
    {
        $this->nodeUrl = $nodeUrl;
        $this->bearerToken = $bearerToken;
    }

    public function getLastApiVersion(): ?string
    {
        return $this->lastApiVersion;
    }

    /**
     * Put deploy into the network
     *
     * @param Deploy $deploy
     * @return string
     *
     * @throws RpcError
     */
    public function putDeploy(Deploy $deploy): string
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_PUT_DEPLOY,
            array(
                'deploy' => DeploySerializer::toJson($deploy)
            )
        );

        return $response['deploy_hash'];
    }

    /**
     * Obtain a deploy from the network by deploy hash
     *
     * @param string $deployHash
     * @return Deploy
     *
     * @throws \Exception
     */
    public function getDeploy(string $deployHash): Deploy
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_DEPLOY_INFO,
            array(
                'deploy_hash' => $deployHash
            )
        );

        return DeploySerializer::fromJson($response['deploy']);
    }

    /**
     * @throws RpcError
     */
    public function getBlockByHash(string $blockHash): Block
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_INFO,
            array(
                'block_identifier' => array(
                    'Hash' => $blockHash
                )
            )
        );

        if (isset($response['block']) && $response['block']['hash'] !== $blockHash) {
            throw new RpcError('Returned block does not have a matching hash');
        }

        return BlockSerializer::fromJson($response['block']);
    }

    /**
     * @throws RpcError
     */
    public function getBlockByHeight(int $height): Block
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_INFO,
            array(
                'block_identifier' => array(
                    'Height' => $height
                )
            )
        );

        if (isset($response['block']) && $response['block']['header']['height'] !== $height) {
            throw new RpcError('Returned block does not have a matching height');
        }

        return BlockSerializer::fromJson($response['block']);
    }

    /**
     * @throws RpcError
     */
    public function getLatestBlock(): Block
    {
        return BlockSerializer::fromJson(
            $this->rpcCallMethod(self::RPC_METHOD_GET_BLOCK_INFO)['block']
        );
    }

    /**
     * @return Peer[]
     * @throws RpcError
     */
    public function getPeers(): array
    {
        return PeerSerializer::fromJsonArray(
            $this->rpcCallMethod(self::RPC_METHOD_GET_PEERS)['peers']
        );
    }

    /**
     * @throws \Exception
     */
    public function getStatus(): Status
    {
        return StatusSerializer::fromJson(
            $this->rpcCallMethod(self::RPC_METHOD_GET_STATUS)
        );
    }

    /**
     * @throws RpcError
     */
    public function getAuctionState(): AuctionState
    {
        return AuctionStateSerializer::fromJson(
            $this->rpcCallMethod(self::RPC_METHOD_GET_VALIDATORS_INFO)['auction_state']
        );
    }

    /**
     * @throws RpcError
     */
    public function getStateRootHash(string $blockHash = ''): string
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_STATE_ROOT_HASH,
            $blockHash ? [array('Hash' => $blockHash)] : []
        );

        return $response['state_root_hash'];
    }

    public function getAccount(string $blockHash, CLPublicKey $publicKey): Account
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_ACCOUNT_INFO,
            array(
                'block_identifier' => array(
                    'Hash' => $blockHash
                ),
                'public_key' => CLPublicKeySerializer::toHex($publicKey),
            )
        );

        return AccountSerializer::fromJson($response['account']);
    }

    /**
     * @throws RpcError
     */
    public function getAccountBalance(string $stateRootHash, CLURef $balanceUref): \GMP
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_ACCOUNT_BALANCE,
            array(
                'state_root_hash' => $stateRootHash,
                self::PURSE_IDENTIFIER_TYPE_UREF => CLURefSerializer::toString($balanceUref),
            )
        );

        return gmp_init($response['balance_value']);
    }

    /**
     * @throws RpcError
     */
    public function queryBalance(
        string $purseIdentifierType,
        string $purseIdentifier,
        string $stateRootHash = null
    ): \GMP
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_QUERY_BALANCE,
            array(
                'purse_identifier' => array(
                    $purseIdentifierType => $purseIdentifier
                ),
                'state_identifier' => $stateRootHash
                    ? array('StateRootHash' => $stateRootHash)
                    : null
            )
        );

        return gmp_init($response['balance']);
    }

    /**
     * @throws RpcError
     */
    public function getAccountBalanceUrefByAccountHash(string $stateRootHash, CLAccountHash $accountHash): CLURef
    {
        return $this->getBlockState($stateRootHash, $accountHash->parsedValue())
            ->getAccount()
            ->getMainPurse();
    }

    /**
     * @throws \Exception
     */
    public function getAccountBalanceUrefByPublicKey(string $stateRootHsh, CLPublicKey $publicKey): CLURef
    {
        return $this->getAccountBalanceUrefByAccountHash(
            $stateRootHsh,
            CLAccountHashSerializer::fromString($publicKey->toAccountHashString())
        );
    }

    /**
     * @throws RpcError
     * @throws \Exception
     */
    public function getBlockState(string $stateRootHash, string $key, array $path = []): StoredValue
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_STATE,
            array(
                'state_root_hash' => $stateRootHash,
                'key' => $key,
                'path' => $path,
            )
        );

        return StoredValueSerializer::fromJson($response['stored_value']);
    }

    /**
     * @return Transfer[]
     * @throws RpcError
     */
    public function getBlockTransfers(string $blockHash = null): array
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_TRANSFERS,
            array('block_identifier' => ($blockHash ? array('Hash' => $blockHash) : null))
        );

        return TransferSerializer::fromJsonArray($response['transfers']);
    }

    /**
     * @throws RpcError
     */
    public function getEraSummaryBySwitchBlockHash(string $blockHash): ?EraSummary
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_ERA_INFO_BY_SWITCH_BLOCK,
            array(
                'block_identifier' => array(
                    'Hash' => $blockHash
                )
            )
        );

        return isset($response['era_summary'])
            ? EraSummarySerializer::fromJson($response['era_summary'])
            : null;
    }

    /**
     * @throws RpcError
     */
    public function getEraSummaryBySwitchBlockHeight(int $height): ?EraSummary
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_ERA_INFO_BY_SWITCH_BLOCK,
            array(
                'block_identifier' => array(
                    'Height' => $height
                )
            )
        );

        return isset($response['era_summary'])
            ? EraSummarySerializer::fromJson($response['era_summary'])
            : null;
    }

    /**
     * @throws \Exception
     */
    public function getDictionaryItemByURef(
        string $stateRootHash,
        string $dictionaryItemKey,
        string $seedUref
    ): StoredValue
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_DICTIONARY_ITEM,
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

        return StoredValueSerializer::fromJson($response['stored_value']);
    }

    /**
     * @throws RpcError
     */
    public function getGlobalStateByBlock(string $blockHash, string $key, array $path = []): GlobalState
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_QUERY_GLOBAL_STATE,
            array(
                'state_identifier' => array(
                    'BlockHash' => $blockHash
                ),
                'key' => $key,
                'path' => $path,
            )
        );

        return GlobalStateSerializer::fromJson($response);
    }

    /**
     * @throws RpcError
     */
    public function getGlobalStateByStateRootHash(string $stateRootHash, string $key, array $path = []): GlobalState
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_QUERY_GLOBAL_STATE,
            array(
                'state_identifier' => array(
                    'StateRootHash' => $stateRootHash
                ),
                'key' => $key,
                'path' => $path,
            )
        );

        return GlobalStateSerializer::fromJson($response);
    }

    /**
     * @throws RpcError
     */
    public function getChainspecInfo(): ChainspecRegistryBytes
    {
        return ChainspecRegistryBytesSerializer::fromJson(
            $this->rpcCallMethod(self::RPC_METHOD_INFO_GET_CHAINSPEC)['chainspec_bytes']
        );
    }

    /**
     * @throws RpcError
     */
    public function speculativeExecution(Deploy $signedDeploy, string $blockHash = null): DeployExecutionResult
    {
        $params = array(
            'deploy' => DeploySerializer::toJson($signedDeploy)
        );

        if ($blockHash !== null) {
            $params['block_identifier'] = array(
                'Hash' => $blockHash
            );
        }

        return DeployExecutionResultSerializer::fromJson(
            $this->rpcCallMethod(self::RPC_METHOD_SPECULATIVE_EXEC, $params)
        );
    }

    /**
     * @throws RpcError
     */
    private function rpcCallMethod(string $method, array $params = array()): array
    {
        $url = $this->nodeUrl . '/rpc';
        $curl = curl_init($url);

        $headers = ['Accept: application/json', 'Content-type: application/json'];
        if ($this->bearerToken !== null) {
            $headers[] = 'Authorization: Bearer ' . $this->bearerToken;
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(
            array(
                'id' => self::ID,
                'jsonrpc' => self::JSON_RPC,
                'method' => $method,
                'params' => $params
            )
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $decodedResponse = json_decode($response, true);

        if ($decodedResponse === null || isset($decodedResponse['error'])) {
            $message = $decodedResponse['error']['message'] ?? 'Empty response';
            $code = $decodedResponse['error']['code'] ?? 0;

            throw new RpcError($message, $code);
        }

        $this->lastApiVersion = $decodedResponse['result']['api_version'];
        return $decodedResponse['result'];
    }
}
