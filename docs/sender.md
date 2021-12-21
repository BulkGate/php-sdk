BulkGate SMS - PHP SDK
=============

[![Downloads](https://img.shields.io/packagist/dt/bulkgate/sms.svg)](https://packagist.org/packages/bulkgate/sms)
[![Latest Stable Version](https://img.shields.io/github/release/bulkgate/sms.svg)](https://github.com/bulkgate/sms/releases)
[![License](https://img.shields.io/github/license/bulkgate/sms.svg)](https://github.com/BulkGate/sms/blob/master/LICENSE)

- [BulkGate portal](https://portal.bulkgate.com/) 
- [BulkGate](https://www.bulkgate.com/)

## Basic instalation

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

## Nette instalation

You can also use DI container to install this SDK

```neon
extensions:
	sdk: BulkGate\Sdk\DI\Extension

sdk:
	application_id: 0000
	application_token: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
	sender:
		tag: 'sdk'
		default_country: cz
	configurator:
		sms:
			sender_id: gText
			sender_id_value: 'Example'
			unicode: true
```

## API administration & tokens

[API administration](https://help.bulkgate.com/docs/en/api-administration.html)

[API token](https://help.bulkgate.com/docs/en/api-tokens.html)
