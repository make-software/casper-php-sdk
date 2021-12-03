<?php

namespace Casper\EventStream;

class EventSource
{
    public const EVENT_TYPE_MAIN = 'main';
    public const EVENT_TYPE_DEPLOYS = 'deploys';
    public const EVENT_TYPE_SIGS = 'sigs';

    private string $url;

    private $onMessage;

    private bool $aborted = false;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function onMessage(callable $callback): void
    {
        $this->onMessage = $callback;
    }

    public function abort()
    {
        $this->aborted = true;
    }

    /**
     * @throws \Exception
     */
    public function connect(string $eventsType, int $startFrom = 0): void
    {
        $this->assertEventTypeIsValid($eventsType);

        $curl = curl_init($this->url . '/events/' . $eventsType);
        curl_setopt_array($curl, array(
            CURLOPT_WRITEFUNCTION => function ($_, $data) {
                try {
                    $event = new Event(trim($data));

                    if (is_callable($this->onMessage)) {
                        ($this->onMessage)($event);
                    }
                } catch (\Exception $_) {
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
    private function assertEventTypeIsValid(string $eventType): void
    {
        if (!in_array($eventType, [self::EVENT_TYPE_MAIN, self::EVENT_TYPE_DEPLOYS, self::EVENT_TYPE_SIGS])) {
            throw new \Exception('Invalid event type');
        }
    }
}
