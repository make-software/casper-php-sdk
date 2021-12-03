<?php

namespace Casper\EventStream;

class Event
{
    private ?string $id = null;

    private ?string $name = null;

    private ?array $data = null;

    /**
     * @param string $data
     * @throws \Exception
     */
    public function __construct(string $data)
    {
        if (preg_match_all("/data:(?<data>.*)/", $data, $match)) {
            foreach ($match['data'] as $dataLine) {
                $this->data = json_decode($dataLine, true);
            }
        }

        if (preg_match_all("/(?<key>id|name)\:(?<value>.*)/", $data, $match)) {
            foreach ($match['key'] as $i => $key) {
                $this->{$key} = trim($match['value'][$i]);
            }
        }

        if (!$this->data) {
            throw new \Exception('Invalid event');
        }
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getData(): ?array
    {
        return $this->data;
    }
}
