<?php

namespace Casper\Serializer;

use Casper\Entity\DeployApproval;
use Casper\Interfaces\Serializer;

class DeployApprovalsSerializer implements Serializer
{
    /**
     * @return DeployApproval[]
     */
    public static function fromJson(array $json): array
    {
        $result = [];

        foreach ($json as $approval) {
            $result[] = new DeployApproval($approval['signer'], $approval['signature']);
        }

        return $result;
    }
}
