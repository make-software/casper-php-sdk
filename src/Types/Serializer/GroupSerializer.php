<?php

namespace Casper\Types\Serializer;

use Casper\Types\CLValue\CLURef;
use Casper\Types\Group;

class GroupSerializer extends JsonSerializer
{
    /**
     * @param Group $group
     */
    public static function toJson($group): array
    {
        $keys = [];
        foreach ($group->getKeys() as $key) {
            $keys[] = $key->parsedValue();
        }

        return array(
            'group' => $group->getGroup(),
            'keys' => $keys,
        );
    }

    public static function fromJson(array $json): Group
    {
        $keys = [];
        foreach ($json['keys'] as $key) {
            $keys[] = CLURef::fromString($key);
        }

        return new Group($json['group'], $keys);
    }
}
