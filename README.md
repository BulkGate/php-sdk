BulkGate SMS - PHP SDK
=============

[![Downloads](https://img.shields.io/packagist/dt/bulkgate/sms.svg)](https://packagist.org/packages/bulkgate/sms)
[![Latest Stable Version](https://img.shields.io/github/release/bulkgate/sms.svg)](https://github.com/bulkgate/sms/releases)
[![License](https://img.shields.io/github/license/bulkgate/sms.svg)](https://github.com/BulkGate/sms/blob/master/LICENSE)

- [BulkGate portal](https://portal.bulkgate.com/) 
- [BulkGate](https://www.bulkgate.com/)

## Instalation

The easiest way to install [bulkgate/php-sdk](https://packagist.org/packages/bulkgate/php-sdk) into a project is by using [Composer](https://getcomposer.org/) via the command line.

```
composer require bulkgate/php-sdk
```


If you have the package installed just plug in the autoloader.

``` php
require_once __DIR__ . '/vendor/autoload.php';
```

In order to send messages, you need an instance of the `BulkGate\Sdk\MessageSender` class that requires instance dependency on the `BulkGate\Sdk\Connection\Connection` class. See how to get API access data.

``` php
$connection = new BulkGate\Sdk\Connection\ConnectionStream('APPLICATION_ID', 'APPLICATION_TOKEN');

$sender = new BulkGate\Sdk\MessageSender($connection);
```

At this point, you are ready to send a message.

``` php
$message = new Sms("420603902776", "test_text");
```

The `send()` method will send a message `$message`.

## API administration & tokens

[API administration](https://help.bulkgate.com/docs/en/api-administration.html)

[API token](https://help.bulkgate.com/docs/en/api-tokens.html)

## Transactional message

The `BulkGate\Sdk\Message\Sms` class represents the object of the SMS message, which consists of the content of the message and the recipient.

``` php
use BulkGate\Sdk\Message\Sms;
```

### Recipient

The class accepts as the first argument a phone number that can be entered by a string:

``` php
$message = new Sms("420603902776", "test_text");
```

or accepts an instance of the object `BulkGate\Sdk\Message\Component\PhoneNumber`:

``` php
$message = new Sms(new BulkGate\Sdk\Message\Component\PhoneNumber('777777777', 'cz'), 'test message');
```

To obtain a phone number, you can use the print out the class object `BulkGate\Sdk\Message\Component\PhoneNumber`, which always returns a phone number as a string.

You can also set phone number and iso separately

``` php
$phone_number = new PhoneNumber();
$phone_number->phoneNumber("777777777");
$phone_number->iso("cz");       
```

### Text of the message

The second parameter is the input of the text of the message. There are also 2 options where the first is to enter text using a `string`, and the other is an instance of the class `component\SimpleText`, or `null`.

``` php
$phone_number = new PhoneNumber('777777777', 'cz');
$text = new SimpleText("test <variable>", ["variable" => "message"]);

$message = new Sms($phone_number, $text);
```

Of course, you can define text even after creating an instance of an object using the method `text(string $text, array $variables = [])`

``` php
$phone_number = new PhoneNumber("603902776", "cz");

$message = new Sms($phone_number);

$message->text("test <variable>", ["variable" => "message"])
```

You can use the `getChannels()` method, to retrieve the array of used channels.

``` php
/** @var array $channels */
$channels = $message->getChannels();
```

### Settings

You can accesss public variable settings to configure [sender_id](https://help.bulkgate.com/docs/en/http-advanced-transactional.html#sender-id-type-sender_id) and unicode

``` php
$sender_id = "gText";
$sender_id_value = "Test sender";
$unicode = false;

$message->settings->configure($sender_id, $sender_id_value, $unicode);
```

### JSON Supoort

The `BulkGate\Sms\Message` object implements the `\JsonSerializable` interface that lets you convert it via the `json_encode()` to JSON format.

``` php
/** @var BulkGate\Sdk\Message\Sms $message */
$message = new Sms('420777777777', 'test message');

echo json_encode($message);
```

The output is:

``` json
{
  "primary_channel": "sms",
  "phone_number": "777777777",
  "country": "cz",
  "channels": {
    "sms": {
      "text": "test_text",
      "variables": [],
      "sender_id": "gSystem",
      "sender_id_value": "",
      "unicode": false
    }
  }
}
```

### Convert to string

``` php
$message = new Sms("420777777777", "test_text");
echo (string)$message; // to the output
```

The output is:

``` php
420777777777
```

### Fluent interface

[Fluent interface](https://en.wikipedia.org/wiki/Fluent_interface) is the technique of chaining methods. Every object of this SDK includes fluent interface.

``` php
$phone_number = new PhoneNumber("603902776", "cz");
$phone_number->phoneNumber("777777777")->iso("cz");
```

## Viber message
The `BulkGate\Sdk\Message\Viber` class represents the object of the Viber message, which consists of the content of the message and the recipient.

``` php
use BulkGate\Sdk\Message\Viber;
```

### Recipient

The class accepts as the first argument a phone number that can be entered by a string:

``` php
$message = new Viber("420603902776", "test_text");
```

or accepts an instance of the object `BulkGate\Sdk\Message\Component\PhoneNumber`:

``` php
$message = new Viber(new BulkGate\Sdk\Message\Component\PhoneNumber('777777777', 'cz'), 'test message');
```

To obtain a phone number, you can use the print out the class object `BulkGate\Sdk\Message\Component\PhoneNumber`, which always returns a phone number as a string.

You can also set phone number and iso separately

``` php
$phone_number = new PhoneNumber();
$phone_number->phoneNumber("777777777");
$phone_number->iso("cz");       
```

### Text of the message

The second parameter is the input of the text of the message. There are also 2 options where the first is to enter text using a `string`, and the other is an instance of the class `component\SimpleText`, or `null`.

``` php
$phone_number = new PhoneNumber('777777777', 'cz');
$text = new SimpleText("test <variable>", ["variable" => "message"]);

$message = new Viber($phone_number, $text);
```

Of course, you can define text even after creating an instance of an object using the method `text(string $text, array $variables = [])`

``` php
$phone_number = new PhoneNumber("603902776", "cz");

$message = new Viber($phone_number);

$message->text("test <variable>", ["variable" => "message"])
```

You can use the `getChannels()` method, to retrieve the array of used channels.

``` php
/** @var array $channels */
$channels = $message->getChannels();
```

### Settings
Third parameter of Viber object is `sender` which is defined as `string`. 

``` php
$message = new Viber("420777777777", "text message", "Sender");
```

Viber's functionality provides an option to use buttons and images in your messages

``` php
use BulkGate\Sdk\Message\Component\Button

$button = new Button("Caption", "url");

$message = new Viber("420777777777", "text message", "Sender", $button);
```

Image input parameters include url of image location and boolean that determines whether the image will be zoomable.

``` php
use BulkGate\Sdk\Message\Component\Image;

$image = new Image("image url", false);
```



### JSON Supoort

The `BulkGate\Sms\Message` object implements the `\JsonSerializable` interface that lets you convert it via the `json_encode()` to JSON format.

``` php
/** @var BulkGate\Sdk\Message\Sms $message */
$message = new Viber('420777777777', 'test message');

echo json_encode($message);
```

The output is:

``` json
{
  "primary_channel": "viber",
  "phone_number": "420777777777",
  "country": null,
  "channels": {
    "viber": {
      "text": "test_text",
      "variables": [],
      "sender": null,
      "button_caption": "OK",
      "button_url": "#",
      "image": null,
      "image_zoom": false,
      "expiration": 10800
    }
  }
}
```

### Convert to string

``` php
$message = new Viber("420777777777", "test_text");
echo (string)$message;
```

The output is:

``` php
420777777777
```

### Fluent interface

[Fluent interface](https://en.wikipedia.org/wiki/Fluent_interface) is the technique of chaining methods. Every object of this SDK includes fluent interface.

``` php
$phone_number = new PhoneNumber("603902776", "cz");
$phone_number->phoneNumber("777777777")->iso("cz");
```


## Multichannel message

Multichannel allows you to send message via Viber and in case recipient does not own Viber account, SMS message will be send instead.

``` php
$phone_number = new PhoneNumber("420777777777", "cz");
$text = new SimpleText("test <variable>", ["variable" => "message"]);
$button = new Button("Caption", "url");
$image = new Image("image url", false);
$timeout = 5;

$message = new MultiChannel($phone_number);

$message->sms($text, "gText", "Sender", false);
$message->viber($text, "Sender", $button, $image, $timeout);

$this->sender->send($message);
```

### Settings

You can also change the settings of individual channels after the fact

``` php
$message->configure(Channel::SMS, $sender_id, $sender_id_value, $unicode);
$message->configure(Channel::VIBER, "sender", $button, $image, $timeout);
```

### Setting channel

Based on used settings interface method channel can be used.

``` php
$settings = new \BulkGate\Sdk\Message\Settings\Viber(new SimpleText("text_message"), "sender", $button, $image, $timeout);

$message->channel($settings);
```

### Setting primary channel

You can use method `setPrimaryChannel` to set channel priority

``` php
$message->setPrimaryChannel(Channel::VIBER);
```

### Get channels

Method `getChannels` can be used to get channels used in message

``` php
$message->getChannels();
```

The output is:

``` php
[
  0 => 'sms'
  1 => 'viber'
]  
```

### JSON support

The `BulkGate\Sms\Message` object implements the `\JsonSerializable` interface that lets you convert it via the `json_encode()` to JSON format.

``` php
/** @var BulkGate\Sdk\Message\MultiChannel $message */
$message = new MultiChannel('420777777777', 'test message');

echo json_encode($message);
```

``` json
{
  "primary_channel": "viber",
  "phone_number": "420777777777",
  "country": "cz",
  "schedule": null,
  "channels": {
    "sms": {
      "text": "test <variable>",
      "variables": {
        "variable": "message"
      },
      "sender_id": "gText",
      "sender_id_value": "Test sender",
      "unicode": false
    },
    "viber": {
      "text": "text_message",
      "variables": [],
      "sender": "sender",
      "button_caption": "Caption",
      "button_url": "url",
      "image": "image url",
      "image_zoom": false,
      "expiration": 5
    }
  }
}
```

### Fluent interface

[Fluent interface](https://en.wikipedia.org/wiki/Fluent_interface) is the technique of chaining methods. Every object of this SDK includes fluent interface.

``` php
$phone_number = new PhoneNumber("603902776", "cz");
$phone_number->phoneNumber("777777777")->iso("cz");
```


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

You can browse through messsages using the foreach cycle

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
