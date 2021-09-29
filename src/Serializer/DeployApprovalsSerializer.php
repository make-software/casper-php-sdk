<?php

namespace Casper\Serializer;

use Casper\Entity\DeployApproval;

class DeployApprovalsSerializer extends Serializer
{
    /**
     * @param $object
     * @return array
     */
    public static function toJson($object): array
    {
        // TODO: Implement toJson() method.
        return [];
    }

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
