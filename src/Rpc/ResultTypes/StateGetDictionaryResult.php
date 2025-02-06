<?php

namespace Casper\Rpc\ResultTypes;

use Casper\Types\Serializer\StoredValueSerializer;
use Casper\Types\StoredValue;

class StateGetDictionaryResult extends AbstractResult
{
    private string $dictionaryKey;

    private StoredValue $storedValue;

    public static function fromJSON(array $json): self
    {
        return new self($json, $json['dictionary_key'], StoredValueSerializer::fromJson($json['stored_value']));
    }

    public function __construct(array $rawJSON, string $dictionaryKey, StoredValue $storedValue)
    {
        parent::__construct($rawJSON);
        $this->dictionaryKey = $dictionaryKey;
        $this->storedValue = $storedValue;
    }

    public function getDictionaryKey(): string
    {
        return $this->dictionaryKey;
    }

    public function getStoredValue(): StoredValue
    {
        return $this->storedValue;
    }
}
