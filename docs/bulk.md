## Bulk SMS (Campaign)

The class `BulkGate\Sdk\Message\Bulk` represents the object, which connects all types of messages (`BulkGate\Sdk\Message\Sms`, `BulkGate\Sdk\Message\Viber`, `BulkGate\Sdk\Message\MultiChannel`) to a bulk message (campaign).

```php
$sms_message = new Sms('420777777777', new SimpleText("test <variable>", ["variable" => "message"]));

$viber_message = new Viber(
    '420777777777', 
    new SimpleText("test <variable>", ["variable" => "message"]), 
    "Sender", 
    new Button("Caption", "https://www.bulkgate.com/")
);

$multi_channel_message = new MultiChannel($phone_number);
$multi_channel_message->sms(new SimpleText("test <variable>", ["variable" => "message"]));
$multi_channel_message->viber(
    new SimpleText("test <variable>", ["variable" => "message"]),
    "Sender", 
    new Button("GO TO BULKGATE", "https://www.bulkgate.com/")
);

$message = new Bulk([$sms_message, $viber_message, $multi_channel_message]);
```

### Adding messages 
Also you can adding message via `\ArrayAccess` interface.

```php
$message = new Bulk();

$message[] = new Sms('420777777777', 'test SMS');
```

### Iterator

You can go through messsages in bulk message using the foreach cycle

```php
/** 
 * @var BulkGate\Sdk\Message\Bulk $bulk_message 
 * @var BulkGate\Sdk\Message\Base $message
 */
foreach($bulk_message as $message)
{
    var_dump($message);
}
```

You can basicaly treat the bulk message as an array

```php
$bulk_message['sms'] = new Sms("420777777777", "text_message");

isset(bulk_message);

count($bulk_message);

unset($bulk_message['sms']);
```
