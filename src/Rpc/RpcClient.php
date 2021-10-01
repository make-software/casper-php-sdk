<?php

namespace Casper\Rpc;

use Casper\Entity\AuctionState;
use Casper\Entity\Block;
use Casper\Entity\Deploy;
use Casper\Entity\EraSummary;
use Casper\Entity\Peer;
use Casper\Entity\Status;
use Casper\Entity\StoredValue;
use Casper\Entity\Transfer;
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

    private ?string $lastApiVersion = null;

    public function __construct(string $nodeUrl)
    {
        $this->nodeUrl = $nodeUrl;
    }

    public function getLastApiVersion(): ?string
    {
        return $this->lastApiVersion;
    }

    /**
     * @throws \Exception
     */
    public function getDeploy(string $blockHashBase16): Deploy
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_DEPLOY_INFO,
            array(
                'deploy_hash' => $blockHashBase16
            )
        );

        return DeploySerializer::fromJson($response['deploy']);
    }

    /**
     * @throws RpcError
     */
    public function getBlock(string $deployHashBase16): Block
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_BLOCK_INFO,
            array(
                'block_identifier' => array(
                    'Hash' => $deployHashBase16
                )
            )
        );

        if (isset($response['block']) && $response['block']['hash'] !== $deployHashBase16) {
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
        return PeerSerializer::fromArray(
            $this->rpcCallMethod(self::RPC_METHOD_GET_PEERS)['peers']
        );
    }

    /**
     * @throws RpcError
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
    public function getStateRootHash(string $blockHashBase16): string
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_STATE_ROOT_HASH,
            array('block_hash' => $blockHashBase16)
        );

        return $response['state_root_hash'];
    }

    /**
     * @throws RpcError
     */
    public function getAccountBalance(string $stateRootHash, string $balanceUref): \GMP
    {
        $response = $this->rpcCallMethod(
            self::RPC_METHOD_GET_ACCOUNT_BALANCE,
            array(
                'state_root_hash' => $stateRootHash,
                'purse_uref' => $balanceUref,
            )
        );

        return gmp_init($response['balance_value']);
    }

    /**
     * @throws RpcError
     */
    public function getAccountBalanceUrefByAccountKeyHash(string $stateRootHash, string $accountHash): string
    {
        return $this->getBlockState($stateRootHash, "account-hash-$accountHash", [])
            ->getAccount()
            ->getMainPurse();
    }

    /**
     * @throws \Exception
     */
    public function getAccountBalanceUrefByPublicKey(string $stateRootHsh, CLPublicKey $publicKey): string
    {
        return $this->getAccountBalanceUrefByAccountKeyHash($stateRootHsh, $publicKey->toAccountHashString());
    }

    /**
     * @throws RpcError
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

        return TransferSerializer::fromArray($response['transfers']);
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

        return EraSummarySerializer::fromJson($response['era_summary'] ?? []);
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

        return EraSummarySerializer::fromJson($response['era_summary'] ?? []);
    }

    /**
     * @throws RpcError
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
    private function rpcCallMethod(string $method, array $params = array()): array
    {
        $url = $this->nodeUrl . '/rpc';
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

        $this->lastApiVersion = $decodedResponse['result']['api_version'];
        return $decodedResponse['result'];
    }
}
