Message sender
==============

## Basic installation

The easiest way to install [bulkgate/php-sdk](https://packagist.org/packages/bulkgate/php-sdk) into a project is by using [Composer](https://getcomposer.org/) via the command line.

```
composer require bulkgate/php-sdk
```


If you have the package installed just plug in the autoloader.

```php
require_once __DIR__ . '/vendor/autoload.php';
```

```php
use BulkGate\Sdk\Connection\ConnectionStream;
use BulkGate\Sdk\MessageSender;
use BulkGate\Sdk\Scheduler\Simple;
use BulkGate\Sdk\Configurator\ViberConfigurator;
```


In order to send messages, you need an instance of the `BulkGate\Sdk\MessageSender` class that requires instance dependency on the `BulkGate\Sdk\Connection\Connection` class. See how to get API access data.

```php
$connection = new ConnectionStream(/*application_id: */ 0000, /*application_token:*/ 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');

$sender = new MessageSender($connection);
```

At this point, you are ready to send a message.

```php
$message = new Sms('420603902776', 'test_text');

$sender->send($message);
```

The `send()` method will send a message `$message`.

### Optional configuration

```php
$sender->setTag('your identificator');
```

If you want to use national phone numbers you must set default country.
```php
$sender->setDefaultCountry('sk');
```

You can add [configurators](configurators.md) to sender.

```php
$viber_configurator = new ViberConfigurator('Sender');

$sender->addSenderConfigurator($viber_configurator);
```

For scheduling you can add instance of `BulkGate\Sdk\Scheduler\Scheduler`.

```php
$scheduler = new Simple(new DateTime('2022-05-14 20:00:00'));

$sender->setScheduler($scheduler);
```

## Nette installation

You can also use DI container to install this SDK

```neon
extensions:
	sdk: BulkGate\Sdk\DI\Extension

sdk:
	application_id: 0000
	application_token: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
	sender:
		tag: 'sdk' # Optional
		default_country: cz # Optional
	configurator:
		sms: # Optional
			sender_id: gText
			sender_id_value: 'Example'
			unicode: true
		viber: # Optional
			sender: Sender
			button:
				caption: 'Button Caption'
				url: 'https://www.bulkgate.com/'
			image: 
				url: 'https://www.example.com/example.png'
				zoom: true
			expiration: 3600 # seconds
```

## API administration & tokens

[API administration](https://help.bulkgate.com/docs/en/api-administration.html)

[API token](https://help.bulkgate.com/docs/en/api-tokens.html)
