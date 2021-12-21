Multichannel message
====================

Multichannel allows you to send message via Viber and in case recipient does not own Viber account, SMS message will be send instead.

```php
$phone_number = new PhoneNumber('420777777777', 'cz');
$text = new SimpleText('test <variable>', ['variable' => 'message']);
$button = new Button('Caption', 'url');
$image = new Image('image url', false);
$timeout = 5;

$message = new MultiChannel($phone_number);

$message->sms($text, 'gText', 'Sender', false);
$message->viber($text, 'Sender', $button, $image, $timeout);

$this->sender->send($message);
```

### Settings

You can also change the settings of individual channels after the fact

```php
$message->configure(Channel::SMS, $sender_id, $sender_id_value, $unicode);
$message->configure(Channel::VIBER, 'sender', $button, $image, $timeout);
```

### Setting channel

Based on used settings interface method channel can be used.

```php
$settings = new \BulkGate\Sdk\Message\Settings\Viber(new SimpleText('text_message'), 'sender', $button, $image, $timeout);

$message->channel($settings);
```

### Setting primary channel

You can use method `setPrimaryChannel` to set channel priority

```php
$message->setPrimaryChannel(Channel::VIBER);
```
