<?php

namespace Casper\Serializer;

use Casper\Entity\Group;

class GroupEntitySerializer extends EntitySerializer
{
    /**
     * @param Group $group
     * @return array
     */
    public static function toJson($group): array
    {
        return array(
            'group' => $group->getGroup(),
            'keys' => $group->getKeys(),
        );
    }

    public static function fromJson(array $json): Group
    {
        return new Group(
            $json['group'],
            $json['keys']
        );
    }
}
