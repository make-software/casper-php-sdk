<?php

namespace Casper\EventStream;

class EventStream
{
    public const STREAM_PATH_MAIN = '/events/main';
    public const STREAM_PATH_DEPLOYS = '/events/deploys';
    public const STREAM_PATH_SIGS = '/events/sigs';

    private string $nodeUrl;

    private string $streamPath;

    private int $startFromEvent;

    private $onEvent;

    private bool $aborted = false;

    /**
     * @throws \Exception
     */
    public function __construct(string $nodeUrl, string $streamPath, int $startFromEvent = 0)
    {
        $this->assertSteamPathIsValid($streamPath);

        $this->nodeUrl = $nodeUrl;
        $this->streamPath = $streamPath;
        $this->startFromEvent = $startFromEvent;
    }

    public function onEvent(callable $onEvent): void
    {
        $this->onEvent = $onEvent;
    }

    public function abort()
    {
        $this->aborted = true;
    }

    /**
     * @throws \Exception
     */
    public function listen(): void
    {
        $curl = curl_init($this->nodeUrl . $this->streamPath);
        curl_setopt_array($curl, array(
            CURLOPT_WRITEFUNCTION => function ($_, $data) {
                $event = new Event(trim($data));

                if (is_callable($this->onEvent) && $event->getId() >= $this->startFromEvent && $event->getData()) {
                    ($this->onEvent)($event);
                }

                return strlen($data);
            },
            CURLOPT_NOPROGRESS => false,
            CURLOPT_PROGRESSFUNCTION => function () {
                return $this->aborted;
            }
        ));
        curl_exec($curl);
        $error = curl_error($curl);

        if (!$this->aborted && $error) {
            throw new \Exception($error);
        }

        curl_close($curl);
    }

    /**
     * @throws \Exception
     */
    private function assertSteamPathIsValid(string $streamPath): void
    {
        if (!in_array($streamPath, [self::STREAM_PATH_MAIN, self::STREAM_PATH_DEPLOYS, self::STREAM_PATH_SIGS])) {
            throw new \Exception('Invalid stream path');
        }
    }
}
