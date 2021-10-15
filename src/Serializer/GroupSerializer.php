<?php

namespace Casper\Serializer;

use Casper\Entity\Group;

class GroupSerializer extends JsonSerializer
{
    /**
     * @param Group $group
     */
    public static function toJson($group): array
    {
        return array(
            'group' => $group->getGroup(),
            'keys' => CLURefSerializer::toStringArray($group->getKeys()),
        );
    }

    public static function fromJson(array $json): Group
    {
        return new Group(
            $json['group'],
            CLURefSerializer::fromStringArray($json['keys'])
        );
    }
}
