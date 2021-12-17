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

In order to send messages, you need an instance of the BulkGate\Sdk\MessageSender class that requires instance dependency on the BulkGate\Sdk\Connection\Connection class. See how to get API access data.

```
$connection = new BulkGate\Sdk\Connection\ConnectionStream('APPLICATION_ID', 'APPLICATION_TOKEN');

$sender = new BulkGate\Sdk\MessageSender($connection);
```

At this point, you are ready to send a message.

```
$message = new Sms("420603902776", "test_text");

$message->settings->configure("gSystem", "Test sender", false);
```

The send() method will send a message $message.

## API administration & tokens

[API administration](https://help.bulkgate.com/docs/en/api-administration.html)

[API token](https://help.bulkgate.com/docs/en/api-tokens.html)

## Transactional message

The BulkGate\Sdk\Message\Sms class represents the object of the SMS message, which consists of the content of the message and the recipient.

```
use BulkGate\Sdk\Message\Sms;
```

### Recipient

The class accepts as the first argument a phone number that can be entered by a string:

```
$message = new Sms("420603902776", "test_text");
```

or accepts an instance of the object BulkGate\Sdk\Message\Component\PhoneNumber:

```
$message = new Sms(new BulkGate\Sdk\Message\Component\PhoneNumber('777777777', 'cz'), 'test message');
```

To obtain a phone number, you can use the print out the class object BulkGate\Sdk\Message\Component\PhoneNumber, which always returns a phone number in string.

You can also set phone number and iso separately

```
$phone_number = new PhoneNumber();
$phone_number->phone_number("777777777");
$phone_number->iso("cz");       
```

### Text of the message

The second parameter is the input of the text of the message. There are also 2 options where the first is to enter text using a string, and the other is an instance of the class omponent\SimpleText, or null.

```
$text = new SimpleText("test <variable>", ["variable" => "message"]);
```

