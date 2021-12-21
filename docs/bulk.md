## Bulk SMS (Campaign)

The class `BulkGate\Sdk\Message\Bulk` represents the object, which connects all types of messages (BulkGate\Sdk\Message\Sms, BulkGate\Sdk\Message\Viber, BulkGate\Sdk\Message\MultiChannel) to a bulk message (campaign).

```php
$phone_number = new PhoneNumber("420777777777", "cz");
$text = new SimpleText("test <variable>", ["variable" => "message"]);
$button = new Button("Caption", "url");
$image = new Image("image url", false);
$timeout = 5;

$sms_message = new Sms($phone_number, $text);

$viber_message = new Viber($phone_number, $text, "sender", $button, $image, $timeout);

$multi_channel_message = new MultiChannel($phone_number);
$multi_channel_message->sms($text, "gText", "Sender", false);
$multi_channel_message->viber($text, "Sender", $button, $image, $timeout);

$message = new Bulk([$sms_message, $viber_message, $multi_channel_message]);

$this->sender->send($message);
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
    echo $message;
}
```

You can basicaly treat the bulk message as an array

```php
$bulk_message['sms'] = new Sms("420777777777", "text_message");

isset(bulk_message);

count($bulk_message);

unset($bulk_message['sms']);
```
