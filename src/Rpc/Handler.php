<?php

namespace Casper\Rpc;

interface Handler
{
    public function processCall(RpcRequest $params): RpcResponse;
}
