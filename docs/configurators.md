# Configurators

Configurators are classes that provides specialized interface for all message types

## Sms configurator

This particular configurator provides methods for setting all sender types

```php
$message = new Sms("420777777777", "text_message");
$sms_configurator = new SmsConfigurator();
```

### Text sender
```php
$sms_configurator->textSender("Sender");
$sms_configurator->configure($message);
```

### Numeric sender
```php
$sms_configurator->numericSender("0451");
$sms_configurator->configure($message);
```

### Short code
```php
$sms_configurator->shortCode('');
$sms_configurator->configure($message);
```

### System number
```php
$sms_configurator->systemNumber();
$sms_configurator->configure($message);
```

### Mobile connect
```php
$sms_configurator->mobileConnect("mobile_connect_id");
$sms_configurator->configure($message);
```

### Portal profile
```php
$sms_configurator->portalProfile(12);
$sms_configurator->configure($message);
```

### Unicode
```php
$message = new Sms("420777777777", "text_message");

$sms_configurator->unicode();
$sms_configurator->configure($message);
```

## Sms country configurator
This configurator allows you to set message country code

```php
$message = new Sms("420777777777", "text_message");

$country_configurator = new SmsCountryConfigurator(true);
$country_configurator->addCountry("cz");
$country_configurator->configure($message);
```


## Viber configurator

Viber configurator is a class that provides methods to configure all aspect of Viber message including buttons, images and expiration times

```php
$viber_message = new Viber("420777777777");

$viber_configurator = new ViberConfigurator("Sender");

$viber_configurator->button("caption", "url");
$viber_configurator->image("url");
$viber_configurator->expiration(5000);

$viber_configurator->configure($viber_message);
```
