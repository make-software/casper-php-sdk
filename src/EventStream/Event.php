<?php

namespace Casper\EventStream;

class Event
{
    private ?int $id = null;

    private ?array $data = null;

    /**
     * @param string $data
     * @throws \Exception
     */
    public function __construct(string $data)
    {
        if (preg_match_all("/data:(?<data>.*)/", $data, $match)) {
            $this->data = json_decode($match['data'][0], true);
        }

        if (preg_match_all("/id:(?<id>.*)/", $data, $match)) {
            $this->id = $match['id'][0];
        }
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getData(): ?array
    {
        return $this->data;
    }
}
