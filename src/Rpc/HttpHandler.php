<?php

namespace Casper\Rpc;

class HttpHandler implements Handler
{
    private string $url;

    private array $headers;

    public function __construct(string $url, array $headers = array())
    {
        $this->url = $url;
        $this->headers = $headers;
    }

    public function processCall(RpcRequest $params): RpcResponse
    {
        $curl = curl_init($this->url);

        $headers = [
            'Accept: application/json',
            'Content-type: application/json'
        ];

        foreach ($this->headers as $name => $value) {
            $headers[] = "$name: $value";
        }

        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params->toJson());

        $rawResponse = curl_exec($curl);
        curl_close($curl);

        return RpcResponse::fromArray(json_decode($rawResponse, true));
    }
}
