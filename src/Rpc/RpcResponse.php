<?php

namespace Casper\Rpc;

class RpcResponse
{
    private string $apiVersion;

    /**
     * @var object|array
     */
    private $data;

    public function setApiVersion(string $apiVersion): self
    {
        $this->apiVersion = $apiVersion;
        return $this;
    }

    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    /**
     * @param array|object $data
     * @return $this
     */
    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array|object
     */
    public function getData()
    {
        return $this->data;
    }
}
