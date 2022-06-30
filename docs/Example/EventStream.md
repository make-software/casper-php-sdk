# Event stream

Create `EventStream` instance by passing node url and stream path to the constructor. The third argument `$startFromEvent` is not required but can be used to filter out all events with id below `$startFromEvent` value.  

Available stream paths:
- `EventStream::STREAM_PATH_MAIN` - listen system events
- `EventStream::STREAM_PATH_DEPLOYS` - listen deploy events
- `EventStream::STREAM_PATH_SIGS` - listen finality signatures events

Set event handler callback function to `EventStream` instance with `onEvent()` method.
For event stream aborting use `abort()` method.

Use `listen()` method for connecting to the node.

## Example

```php
$nodeUrl = 'http://localhost:9999';
$streamPath = \Casper\EventStream\EventStream::STREAM_PATH_MAIN;
$startFromEvent = 12345;

$es = new Casper\EventStream\EventStream($nodeUrl, $streamPath, $startFromEvent);
$es->onEvent(
    function (\Casper\EventStream\Event $event) use ($es) {
        if ($event->getId() === null) {
            $es->abort();
            return;
        }
        
        echo json_encode($event->getData()) . "\n";
    }
);

$es->listen();
```
