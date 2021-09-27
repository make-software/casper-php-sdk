<?php

namespace Casper\Rpc;

use Casper\CLType\CLPublicKey;
use Casper\Entity\Deploy;
use Casper\Serializer\DeploySerializer;

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
        $response->setData(
            array_merge(
                $responseData,
                array('deploy' => DeploySerializer::fromJson($responseData['deploy']))
            )
        );

        return $response;
    }

    /**
     * @throws RpcError
     */
    public function getBlockInfo(string $deployHashBase16): RpcResponse
    {
        $result = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_INFO,
            array(
                'block_identifier' => array(
                    'Hash' => $deployHashBase16
                )
            )
        );
        $data = $result->getData();

        if (isset($data['block']) && $data['block']['hash'] !== $deployHashBase16) {
            throw new RpcError('Returned block does not have a matching hash');
        }

        return $result;
    }

    /**
     * @throws RpcError
     */
    public function getBlockInfoByHeight(int $height): RpcResponse
    {
        $result = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_INFO,
            array(
                'block_identifier' => array(
                    'Height' => $height
                )
            )
        );
        $data = $result->getData();

        if (isset($data['block']) && $data['block']['header']['height'] !== $height) {
            throw new RpcError('Returned block does not have a matching height');
        }

        return $result;
    }

    /**
     * @throws RpcError
     */
    public function getLatestBlockInfo(): RpcResponse
    {
        return $this->rpcCallMethod(self::RPC_METHOD_GET_BLOCK_INFO);
    }

    /**
     * @throws RpcError
     */
    public function getPeers(): RpcResponse
    {
        return $this->rpcCallMethod(self::RPC_METHOD_GET_PEERS);
    }

    /**
     * @throws RpcError
     */
    public function getStatus(): RpcResponse
    {
        return $this->rpcCallMethod(self::RPC_METHOD_GET_STATUS);
    }

    /**
     * @throws RpcError
     */
    public function getValidatorsInfo(): RpcResponse
    {
        return $this->rpcCallMethod(self::RPC_METHOD_GET_VALIDATORS_INFO);
    }

    /**
     * @throws RpcError
     */
    public function getStateRootHash(string $blockHashBase16): string
    {
        $result = $this->rpcCallMethod(
            self::RPC_METHOD_GET_STATE_ROOT_HASH,
            array(
                'block_hash' => $blockHashBase16
            )
        );
        $data = $result->getData();

        return $data['state_root_hash'];
    }

    /**
     * @throws RpcError
     */
    public function getAccountBalance(string $stateRootHash, string $balanceUref): string
    {
        $result = $this->rpcCallMethod(
            self::RPC_METHOD_GET_ACCOUNT_BALANCE,
            array(
                'state_root_hash' => $stateRootHash,
                'purse_uref' => $balanceUref,
            )
        );
        $data = $result->getData();

        return $data['balance_value'];
    }

    /**
     * @throws RpcError
     */
    public function getAccountBalanceUrefByPublicKeyHash(string $stateRootHash, string $accountHash): string
    {
        $result = $this->getBlockState(
            $stateRootHash,
            "account-hash-$accountHash",
            []
        );

        return $result['Account']['main_purse'];
    }

    /**
     * @throws RpcError
     */
    public function getAccountBalanceUrefByPublicKey(string $stateRootHsh, CLPublicKey $publicKey): string
    {
        return $this->getAccountBalanceUrefByPublicKeyHash($stateRootHsh, $publicKey->toAccountHashString());
    }

    /**
     * @throws RpcError
     */
    public function getBlockState(string $stateRootHash, string $key, array $path = []): array
    {
        $result = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_STATE,
            array(
                'state_root_hash' => $stateRootHash,
                'key' => $key,
                'path' => $path,
            )
        );
        $data = $result->getData();

        return $data['stored_value'];
    }

    /**
     * @throws RpcError
     */
    public function getBlockTransfers(string $blockHash = null): RpcResponse
    {
        return $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_TRANSFERS,
            array(
                'block_identifier' => ($blockHash ? array('Hash' => $blockHash) : null)
            )
        );
    }

    /**
     * @throws RpcError
     */
    public function getEraInfoBySwitchBlock(string $blockHash = null): ?array
    {
        $result = $this->rpcCallMethod(
            self::RPC_METHOD_GET_ERA_INFO_BY_SWITCH_BLOCK,
            array(
                'block_identifier' => ($blockHash ? array('Hash' => $blockHash) : null)
            )
        );
        $data = $result->getData();

        return $data['era_summary'];
    }

    /**
     * @throws RpcError
     */
    public function getEraInfoBySwitchBlockHeight(int $height): ?array
    {
        $result = $this->rpcCallMethod(
            self::RPC_METHOD_GET_ERA_INFO_BY_SWITCH_BLOCK,
            array(
                'block_identifier' => array(
                    'Height' => $height
                )
            )
        );
        $data = $result->getData();

        return $data['era_summary'];
    }

    /**
     * @throws RpcError
     */
    public function getDictionaryItemByURef(string $stateRootHash, string $dictionaryItemKey, string $seedUref): array
    {
        $result = $this->rpcCallMethod(
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
        $data = $result->getData();

        return $data['stored_value'];
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
