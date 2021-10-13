<?php

namespace Casper\Serializer;

use Casper\Entity\Group;

class GroupJsonSerializer extends JsonSerializer
{
    /**
     * @param Group $group
     */
    public static function toJson($group): array
    {
        return array(
            'group' => $group->getGroup(),
            'keys' => CLURefStringSerializer::toStringArray($group->getKeys()),
        );
    }

    public static function fromJson(array $json): Group
    {
        return new Group(
            $json['group'],
            CLURefStringSerializer::fromStringArray($json['keys'])
        );
    }
}
