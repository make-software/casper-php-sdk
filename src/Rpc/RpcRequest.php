<?php

namespace Casper\Rpc;

class RpcRequest
{
    private int $id;

    private string $version;

    private string $method;

    private array $params;

    public function __construct(string $method, array $params, int $id = 1, string $version = '2.0')
    {
        $this->id = $id;
        $this->version = $version;
        $this->method = $method;
        $this->params = $params;
    }

    public function toJson(): string
    {
        return json_encode([
            'id' => $this->id,
            'jsonrpc' => $this->version,
            'method' => $this->method,
            'params' => $this->params,
        ]);
    }
}
