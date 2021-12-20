# Configurators

Configurators are classes that provides specialized interface for all message types

## Sms configurator

```php
$message = new Sms("420777777777", "text_message");
$sms_configurator = new SmsConfigurator();
```

### Text sender

```php
$sms_configurator->mobileConnect("mobile_connect_id");
$sms_configurator->configure($message);
```

### Numeric sender
```php
$sms_configurator->numericSender("0451");
$sms_configurator->configure($message);
```

## Sms country configurator

## Viber configurator
