<?php

namespace Casper\Rpc;

class RpcResponse
{
    private ?string $jsonrpc;

    private ?int $id;

    private ?array $result;

    private ?RpcError $error = null;

    private function __construct() {}

    public static function fromArray(array $data): self
    {
        $response = new self();
        $response->jsonrpc = $data['jsonrpc'] ?? null;
        $response->id = $data['id'] ?? null;
        $response->result = $data['result'] ?? null;

        if ($response->result === null || isset($data['error'])) {
            $response->error = new RpcError(
                $data['error']['message'] ?? $data['message'] ?? 'Empty response',
                $data['error']['code'] ?? 0
            );
        }

        return $response;
    }

    public function getJsonrpc(): string
    {
        return $this->jsonrpc;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getResult(): ?array
    {
        return $this->result;
    }

    public function getError(): ?RpcError
    {
        return $this->error;
    }
}
