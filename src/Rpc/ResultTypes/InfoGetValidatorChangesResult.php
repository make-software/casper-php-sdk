<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\Serializer\ValidatorChangesSerializer;
use Casper\Types\ValidatorChanges;

class InfoGetValidatorChangesResult extends AbstractResult
{
    /**
     * @var ValidatorChanges[]
     */
    private array $changes;

    public static function fromJSON(array $json): self
    {
        return new self($json, ValidatorChangesSerializer::fromJsonArray($json['changes']));
    }

    public function __construct(array $rawJSON, array $changes)
    {
        parent::__construct($rawJSON);
        $this->changes = $changes;
    }

    public function getChanges(): array
    {
        return $this->changes;
    }
}
