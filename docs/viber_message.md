Viber message
================

The `BulkGate\Sdk\Message\Viber` class represents the object of the Viber message, which consists of the content of the message and the recipient.

```php
use BulkGate\Sdk\Message\Viber;
use BulkGate\Sdk\Message\Component\{Button, Image, PhoneNumber, SimpleText}
```

### Recipient

The class accepts as the first argument a phone number that can be entered by a string:

```php
$message = new Viber('420777777777', 'test_text');
```

or accepts an instance of the object `BulkGate\Sdk\Message\Component\PhoneNumber`:

```php
$message = new Viber(new PhoneNumber('777777777', 'cz'), 'test message');
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

$message = new Viber($phone_number, $text);
```

Of course, you can define text even after creating an instance of an object using the method `text(string $text, array $variables = [])`

```php
$phone_number = new PhoneNumber('420777777777', 'cz');

$message = new Viber($phone_number);

$message->text('test <variable>', ['variable' => 'message'])
```

### Settings
Third parameter of Viber object is `sender` which is defined as `string`. 

```php
$message = new Viber('420777777777', 'text message', 'Sender');
```

Viber's functionality provides an option to use buttons and images in your messages

Button input parameters include caption string and url determining where the button leads
Image input parameters include url of image location and boolean that determines whether the image will be zoomable.

```php
$button = new Button('Caption', 'url');
$image = new Image('image url', false);

$message = new Viber('420777777777', 'text message', 'Sender', $button, $image);
```
