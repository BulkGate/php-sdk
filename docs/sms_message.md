SMS message
===========

The `BulkGate\Sdk\Message\Sms` class represents the object of the SMS message, which consists of the content of the message and the recipient.

```php
use BulkGate\Sdk\Message\Sms;
use BulkGate\Sdk\Message\Component\{PhoneNumber, SimpleText}
```

### Recipient

The class accepts as the first argument a phone number that can be entered by a string:

```php
$message = new Sms('420603902776', 'test_text');
```

or accepts an instance of the object `BulkGate\Sdk\Message\Component\PhoneNumber`:

```php
$message = new Sms(new PhoneNumber('777777777', 'cz'), 'test message');
```

To obtain a phone number, you can use the print-out the class object `BulkGate\Sdk\Message\Component\PhoneNumber`, which always returns a phone number as a string.

You can also set phone number and iso separately

```php
$phone_number = new PhoneNumber();
$phone_number->phoneNumber('777777777');
$phone_number->iso('cz');       
```

### Text of the message

The second parameter is the input of the text of the message. There are also 2 options where the first is to enter text using a `string`, and the other is an instance of the class `SimpleText`, or `null`.

```php
$phone_number = new PhoneNumber('777777777', 'cz');
$text = new SimpleText('test <variable>', ['variable' => 'message']);

$message = new Sms($phone_number, $text);
```

Of course, you can define text even after creating an instance of an object using the method `text(string $text, array $variables = [])`

```php
$phone_number = new PhoneNumber('603902776', 'cz');

$message = new Sms($phone_number);

$message->text('test <variable>', ['variable' => 'message'])
```

### Settings

You can accesss public variable settings to configure [sender_id](https://help.bulkgate.com/docs/en/http-advanced-transactional.html#sender-id-type-sender_id) and unicode

```php
$sender_id = 'gText';
$sender_id_value = 'Test sender';
$unicode = false;

$message->settings->configure($sender_id, $sender_id_value, $unicode);
```
