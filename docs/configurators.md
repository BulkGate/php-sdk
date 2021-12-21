# Configurators

Configurators are classes that provides specialized interface for all message types

## Sms configurator

This particular configurator provides methods for setting all sender types

```php
use BulkGate\Sdk\Country;
use BulkGate\Sdk\Message\Component\SmsSender;
```

```php
$message = new Sms('420777777777', 'text_message');
$sms_configurator = new SmsConfigurator();
```

### Text sender
```php
$sms_configurator->textSender('BulkGate');
$sms_configurator->configure($message);
```

### Numeric sender
```php
$sms_configurator->numericSender('420777777777');
$sms_configurator->configure($message);
```

### Short code
```php
$sms_configurator->shortCode();
$sms_configurator->configure($message);
```

### System number
```php
$sms_configurator->systemNumber();
$sms_configurator->configure($message);
```

### Mobile connect
```php
$sms_configurator->mobileConnect('key');
$sms_configurator->configure($message);
```

### Portal profile
```php
$sms_configurator->portalProfile(12);
$sms_configurator->configure($message);
```

### Unicode
```php
$message = new Sms('420777777777', 'text_message');

$sms_configurator->unicode();
$sms_configurator->configure($message);
```

## Sms country configurator
This configurator allows you configure specific SMS routes per country.

```php
$message = new Sms('420777777777', 'text_message');

$country_configurator = new SmsCountryConfigurator();
$country_configurator->addCountry(Country::CZECH_REPUBLIC, SmsSender::GATE2, 'BulkGate');
$country_configurator->configure($message);
```


## Viber configurator

Viber configurator is a class that provides methods to configure all aspect of Viber message including buttons, images and expiration times

```php
$viber_message = new Viber('420777777777');

$viber_configurator = new ViberConfigurator('Sender');

$viber_configurator->button('caption', 'url');
$viber_configurator->image('url');
$viber_configurator->expiration(5_000 /*seconds*/);

$viber_configurator->configure($viber_message);
```

## Register Configurator to Sender

```php
$viber_configurator = new ViberConfigurator('Sender');

$sender = new BulkGate\Sdk\MessageSender($connection);

$sender->addSenderConfigurator($viber_configurator);
```

You can register only one configurator per message channel. One for Viber and one for SMS.
