<?php

namespace Casper\Rpc;

use Casper\Rpc\ResultTypes\SpeculativeExecResult;

use Casper\Types\Deploy;
use Casper\Types\Serializer\DeploySerializer;

class SpeculativeClient
{
    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws RpcError
     */
    public function speculativeExecByBlockHash(Deploy $signedDeploy, string $blockHash = null): SpeculativeExecResult
    {
        $params = array(
            'deploy' => DeploySerializer::toJson($signedDeploy)
        );

        if ($blockHash !== null) {
            $params['block_identifier'] = array(
                'Hash' => $blockHash
            );
        }

        return SpeculativeExecResult::fromJson(
            $this->processRequest('speculative_exec', $params)
        );
    }

    /**
     * @throws RpcError
     */
    public function speculativeExecByBlockHeight(Deploy $signedDeploy, int $blockHeight = null): SpeculativeExecResult
    {
        $params = array(
            'deploy' => DeploySerializer::toJson($signedDeploy)
        );

        if ($blockHeight !== null) {
            $params['block_identifier'] = array(
                'Height' => $blockHeight
            );
        }

        return SpeculativeExecResult::fromJson(
            $this->processRequest('speculative_exec', $params)
        );
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
