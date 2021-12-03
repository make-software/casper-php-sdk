# Event stream

Create `EventSource` instance by passing node url to constructor

```php
$nodeUrl = 'http://3.208.91.63:9999';
$es = new Casper\EventStream\EventSource($nodeUrl);
```

Use `connect()` method for connecting to the node. The method has two parameters `$eventsType` and `$startFrom`. The first one is mandatory and second is optional. 

Available events type:
- `EventSource::EVENT_TYPE_MAIN` - listen system events
- `EventSource::EVENT_TYPE_DEPLOYS` - listen deploy events
- `EventSource::EVENT_TYPE_SIGS` - listen finality signatures events

```php
$es->connect(\Casper\EventStream\EventSource::EVENT_TYPE_MAIN);
```

Set event handler callback function to `EventSource` instance with `onMessage()` method.
For event stream aborting use `abort()` method.

## Example

```php
$nodeUrl = 'http://localhost:9999';
$es = new Casper\EventStream\EventSource($nodeUrl);

$es->onMessage(
    function (\Casper\EventStream\Event $event) use ($es) {
        if ($event->getId() === null) {
            $es->abort();
            return;
        }
        
        echo json_encode($event->getData()) . "\n";
    }
);

$es->connect(\Casper\EventStream\EventSource::EVENT_TYPE_MAIN);
```
