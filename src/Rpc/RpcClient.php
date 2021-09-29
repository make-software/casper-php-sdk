<?php

namespace Casper\Rpc;

use Casper\Serializer\AuctionStateSerializer;
use Casper\Serializer\EraSummarySerializer;
use Casper\Serializer\PeerSerializer;
use Casper\Serializer\BlockSerializer;
use Casper\Serializer\DeploySerializer;
use Casper\Serializer\StatusSerializer;

use Casper\CLType\CLPublicKey;
use Casper\Serializer\StoredValueSerializer;
use Casper\Serializer\TransferSerializer;

class RpcClient
{
    private const ID = 1;
    private const JSON_RPC = '2.0';

    private const RPC_METHOD_GET_DEPLOY_INFO = 'info_get_deploy';
    private const RPC_METHOD_GET_BLOCK_INFO = 'chain_get_block';
    private const RPC_METHOD_GET_PEERS = 'info_get_peers';
    private const RPC_METHOD_GET_STATUS = 'info_get_status';
    private const RPC_METHOD_GET_VALIDATORS_INFO = 'state_get_auction_info';
    private const RPC_METHOD_GET_STATE_ROOT_HASH = 'chain_get_state_root_hash';
    private const RPC_METHOD_GET_BLOCK_STATE = 'state_get_item';
    private const RPC_METHOD_GET_BLOCK_TRANSFERS = 'chain_get_block_transfers';
    private const RPC_METHOD_GET_ACCOUNT_BALANCE = 'state_get_balance';
    private const RPC_METHOD_GET_ERA_INFO_BY_SWITCH_BLOCK = 'chain_get_era_info_by_switch_block';
    private const RPC_METHOD_GET_DICTIONARY_ITEM = 'state_get_dictionary_item';

    private string $nodeUrl;

    private ?int $nodePort;

    public function __construct(string $nodeUrl, int $nodePort = null)
    {
        $this->nodeUrl = $nodeUrl;
        $this->nodePort = $nodePort;
    }

    /**
     * @throws \Exception
     */
    public function getDeployInfo(string $blockHashBase16): RpcResponse
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_DEPLOY_INFO,
            array(
                'deploy_hash' => $blockHashBase16
            )
        );
        $responseData = $response->getData();

        return $response->setData(
            array_merge(
                $responseData,
                array('deploy' => DeploySerializer::fromJson($responseData['deploy']))
            )
        );
    }

    /**
     * @throws RpcError
     */
    public function getBlockInfo(string $deployHashBase16): RpcResponse
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_INFO,
            array(
                'block_identifier' => array(
                    'Hash' => $deployHashBase16
                )
            )
        );
        $responseData = $response->getData();

        if (isset($responseData['block']) && $responseData['block']['hash'] !== $deployHashBase16) {
            throw new RpcError('Returned block does not have a matching hash');
        }

        return $response->setData(
            array('block' => BlockSerializer::fromJson($responseData['block']))
        );
    }

    /**
     * @throws RpcError
     */
    public function getBlockInfoByHeight(int $height): RpcResponse
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_INFO,
            array(
                'block_identifier' => array(
                    'Height' => $height
                )
            )
        );
        $responseData = $response->getData();

        if (isset($responseData['block']) && $responseData['block']['header']['height'] !== $height) {
            throw new RpcError('Returned block does not have a matching height');
        }

        return $response->setData(
            array('block' => BlockSerializer::fromJson($responseData['block']))
        );
    }

    /**
     * @throws RpcError
     */
    public function getLatestBlockInfo(): RpcResponse
    {
        $response = $this->rpcCallMethod(self::RPC_METHOD_GET_BLOCK_INFO);
        $responseData = $response->getData();

        return $response->setData(
            array('block' => BlockSerializer::fromJson($responseData['block']))
        );
    }

    /**
     * @throws RpcError
     */
    public function getPeers(): RpcResponse
    {
        $response = $this->rpcCallMethod(self::RPC_METHOD_GET_PEERS);
        $responseData = $response->getData();

        return $response->setData(
            array('peers' => PeerSerializer::fromArray($responseData['peers']))
        );
    }

    /**
     * @throws RpcError
     */
    public function getStatus(): RpcResponse
    {
        $response = $this->rpcCallMethod(self::RPC_METHOD_GET_STATUS);

        return $response->setData(
            StatusSerializer::fromJson($response->getData())
        );
    }

    /**
     * @throws RpcError
     */
    public function getValidatorsInfo(): RpcResponse
    {
        $response = $this->rpcCallMethod(self::RPC_METHOD_GET_VALIDATORS_INFO);
        $responseData = $response->getData();

        $response->setData(
            array_merge(
                $responseData,
                array(
                    'auction_state' => AuctionStateSerializer::fromJson($responseData['auction_state'])
                )
            )
        );

        return $response;
    }

    /**
     * @throws RpcError
     */
    public function getStateRootHash(string $blockHashBase16): string
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_STATE_ROOT_HASH,
            array(
                'block_hash' => $blockHashBase16
            )
        );
        $responseData = $response->getData();

        return $responseData['state_root_hash'];
    }

    /**
     * @throws RpcError
     */
    public function getAccountBalance(string $stateRootHash, string $balanceUref): string
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_ACCOUNT_BALANCE,
            array(
                'state_root_hash' => $stateRootHash,
                'purse_uref' => $balanceUref,
            )
        );
        $responseData = $response->getData();

        return $responseData['balance_value'];
    }

    /**
     * @throws RpcError
     */
    public function getAccountBalanceUrefByPublicKeyHash(string $stateRootHash, string $accountHash): string
    {
        $response = $this->getBlockState(
            $stateRootHash,
            "account-hash-$accountHash",
            []
        );
        $responseData = $response->getData();
        $storedValue = $responseData['stored_value'];

        return $storedValue
            ->getAccount()
            ->getMainPurse();
    }

    /**
     * @throws \Exception
     */
    public function getAccountBalanceUrefByPublicKey(string $stateRootHsh, CLPublicKey $publicKey): string
    {
        return $this->getAccountBalanceUrefByPublicKeyHash($stateRootHsh, $publicKey->toAccountHashString());
    }

    /**
     * @throws RpcError
     */
    public function getBlockState(string $stateRootHash, string $key, array $path = []): RpcResponse
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_STATE,
            array(
                'state_root_hash' => $stateRootHash,
                'key' => $key,
                'path' => $path,
            )
        );
        $responseData = $response->getData();

        return $response->setData(array_merge(
            $responseData,
            array(
                'stored_value' => StoredValueSerializer::fromJson($responseData['stored_value'])
            )
        ));
    }

    /**
     * @throws RpcError
     */
    public function getBlockTransfers(string $blockHash = null): RpcResponse
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_TRANSFERS,
            array(
                'block_identifier' => ($blockHash ? array('Hash' => $blockHash) : null)
            )
        );
        $responseData = $response->getData();

        return $response->setData(array_merge(
            $responseData,
            array(
                'transfers' => TransferSerializer::fromArray($responseData['transfers'])
            )
        ));
    }

    /**
     * @throws RpcError
     */
    public function getEraInfoBySwitchBlock(string $blockHash = null): RpcResponse
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_ERA_INFO_BY_SWITCH_BLOCK,
            array(
                'block_identifier' => ($blockHash ? array('Hash' => $blockHash) : null)
            )
        );
        $responseData = $response->getData();

        return $response->setData(array_merge(
            $responseData,
            array(
                'era_summary' => EraSummarySerializer::fromJson($responseData['era_summary'])
            )
        ));
    }

    /**
     * @throws RpcError
     */
    public function getEraInfoBySwitchBlockHeight(int $height): RpcResponse
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_ERA_INFO_BY_SWITCH_BLOCK,
            array(
                'block_identifier' => array(
                    'Height' => $height
                )
            )
        );
        $responseData = $response->getData();

        return $response->setData(array_merge(
            $responseData,
            array(
                'era_summary' => EraSummarySerializer::fromJson($responseData['era_summary'] ?? [])
            )
        ));
    }

    /**
     * @throws RpcError
     */
    public function getDictionaryItemByURef(string $stateRootHash, string $dictionaryItemKey, string $seedUref): array
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
        $responseData = $response->getData();

        return $responseData['stored_value'];
    }

    /**
     * @throws RpcError
     */
    private function rpcCallMethod(string $method, array $params = array()): RpcResponse
    {
        $url = $this->nodePort ? $this->nodeUrl . ':' . $this->nodePort : $this->nodeUrl;
        $curl = curl_init($url);
        $data = array(
            'id' => self::ID,
            'jsonrpc' => self::JSON_RPC,
            'method' => $method,
            'params' => $params
        );

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-type: application/json',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $decodedResponse = json_decode($response, true);

        if (isset($decodedResponse['error'])) {
            throw new RpcError($decodedResponse['error']['message'], $decodedResponse['error']['code']);
        }

        $apiVersion = $decodedResponse['result']['api_version'];
        unset($decodedResponse['result']['api_version']);

        $rpcResult = new RpcResponse();
        $rpcResult->setApiVersion($apiVersion);
        $rpcResult->setData($decodedResponse['result']);

        return $rpcResult;
    }
}
