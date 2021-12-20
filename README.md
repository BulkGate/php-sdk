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

```
$connection = new BulkGate\Sdk\Connection\ConnectionStream('APPLICATION_ID', 'APPLICATION_TOKEN');

$sender = new BulkGate\Sdk\MessageSender($connection);
```

At this point, you are ready to send a message.

```
$message = new Sms("420603902776", "test_text");
```

The `send()` method will send a message `$message`.

## API administration & tokens

[API administration](https://help.bulkgate.com/docs/en/api-administration.html)

[API token](https://help.bulkgate.com/docs/en/api-tokens.html)

## Transactional message

The `BulkGate\Sdk\Message\Sms` class represents the object of the SMS message, which consists of the content of the message and the recipient.

```
use BulkGate\Sdk\Message\Sms;
```

### Recipient

The class accepts as the first argument a phone number that can be entered by a string:

```
$message = new Sms("420603902776", "test_text");
```

or accepts an instance of the object `BulkGate\Sdk\Message\Component\PhoneNumber`:

```
$message = new Sms(new BulkGate\Sdk\Message\Component\PhoneNumber('777777777', 'cz'), 'test message');
```

To obtain a phone number, you can use the print out the class object `BulkGate\Sdk\Message\Component\PhoneNumber`, which always returns a phone number as a string.

You can also set phone number and iso separately

```
$phone_number = new PhoneNumber();
$phone_number->phoneNumber("777777777");
$phone_number->iso("cz");       
```

### Text of the message

The second parameter is the input of the text of the message. There are also 2 options where the first is to enter text using a `string`, and the other is an instance of the class `component\SimpleText`, or `null`.

```
$phone_number = new PhoneNumber('777777777', 'cz');
$text = new SimpleText("test <variable>", ["variable" => "message"]);

$message = new Sms($phone_number, $text);
```

Of course, you can define text even after creating an instance of an object using the method `text(string $text, array $variables = [])`

```
$phone_number = new PhoneNumber("603902776", "cz");

$message = new Sms($phone_number);

$message->text("test <variable>", ["variable" => "message"])
```

You can use the `getChannels()` method, to retrieve the array of used channels.

```
/** @var array $channels */
$channels = $message->getChannels();
```

## JSON Supoort

The `BulkGate\Sms\Message` object implements the `\JsonSerializable` interface that lets you convert it via the `json_encode()` to JSON format.

```
/** @var BulkGate\Sdk\Message\Sms $message */
$message = new SMS('447971700001', 'test message');

echo json_encode($message);
```

The output is:

```
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

## Convert to string

```
$message = new Sms("420777777777", "test_text");
echo (string)$message; // to the output
```

The output is:

```
420777777777
```

## Fluent interface

[Fluent interface](https://en.wikipedia.org/wiki/Fluent_interface) is the technique of chaining methods. Every object of this SDK includes fluent interface.

```
$phone_number = new PhoneNumber("603902776", "cz");
$phone_number->phoneNumber("777777777")->iso("cz");
```
