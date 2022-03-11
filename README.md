BulkGate SMS/Viber - PHP SDK
=============

[![PHP](https://img.shields.io/packagist/php-v/bulkgate/php-sdk?logo=php&color=8892BF)](https://www.php.net/supported-versions.php)
[![Downloads](https://img.shields.io/packagist/dt/bulkgate/php-sdk.svg)](https://packagist.org/packages/bulkgate/php-sdk)
[![Latest Stable Version](https://img.shields.io/github/release/bulkgate/php-sdk.svg)](https://github.com/bulkgate/php-sdk/releases)
[![License](https://img.shields.io/github/license/bulkgate/php-sdk.svg)](https://github.com/BulkGate/php-sdk/blob/master/LICENSE)
[![Tests](https://github.com/BulkGate/php-sdk/workflows/Run%20tests/badge.svg)](https://github.com/BulkGate/php-sdk/actions/workflows/php.yml)



- [BulkGate](https://www.bulkgate.com/)
- [Helpdesk](https://help.bulkgate.com/)
- [Portal](https://portal.bulkgate.com/) 

## Installation

The easiest way to install [bulkgate/php-sdk](https://packagist.org/packages/bulkgate/php-sdk) into a project is by using [Composer](https://getcomposer.org/) via the command line.

```
composer require bulkgate/php-sdk
```

## Quick start

### Nette DI Extension

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

```php 

use BulkGate\Sdk\Sender;
use BulkGate\Sdk\Message\Sms;

class Sdk
{
    private Sender $sender;

    public funnction __construct(Sender $sender)
    {
        $this->sender = $sender;
    }
    

    public function sendMessage(string $phone_number, string $text): void
    {    
        $this->sender->send(new Sms($phone_number, $text));
    }
}

```

### Manual creation

```php 
use BulkGate\Sdk\Connection\ConnectionStream;
use BulkGate\Sdk\MessageSender;
use BulkGate\Sdk\Message\Sms;

$connection = new ConnectionStream(
    /*application_id: */ 0000, 
    /*application_token:*/ 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'
);

$sender = new MessageSender($connection);

$sender->send(new Sms($phone_number, $text));

/* Optional */

$sender->setTag('sdk');

$sender->setDefaultCountry('cz');

$viber_configurator = new ViberConfigurator('Sender');
$viber_configurator->button('Button Caption', 'https://www.bulkgate.com/');
$viber_configurator->image('https://www.example.com/example.png', true);
$viber_configurator->expiration(3_600);

$sender->addSenderConfigurator($viber_configurator);

$sms_configurator = new SmsConfigurator('gText', 'Example', true);

$sender->addSenderConfigurator($sms_configurator);

$sender->send(new Sms($phone_number, $text));
```

## Simple Manual

- [Message sender](docs/sender.md)
- [SMS](docs/sms_message.md)
- [Viber](docs/viber_message.md)
- [Multi channel message](docs/multichannel_message.md)
- [Bulk message/Campaign](docs/bulk.md)
- [Schedulers](docs/schedulers.md)
- [Configurators](docs/configurators.md)
- [Number checker](docs/number_checker.md)


## API administration & tokens

[API administration](https://help.bulkgate.com/docs/en/api-administration.html)

[API token](https://help.bulkgate.com/docs/en/api-tokens.html)

