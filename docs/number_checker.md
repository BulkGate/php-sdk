## Number checker

Number checker will validate format and an existence of input phone numbers.

```php
$connection = new ConnectionStream('application_id', 'application_token');

$number_checker = new NumberChecker($connection);

$result = $number_checker->check(['608123456', '777777777', '420777777777', new PhoneNumber('603777777'), '42061110'], 'cz');
```

The `$result` is array where keys are phone numbers.

```php
[
    608123456 => [
        'phone_number' => '420608123456',
        'valid' => true,
        'country' => 'cz',
        'call_prefix' => 420,
        'network_code' => '23003',
        'network_name' => 'Vodafone',
    ],
    777777777 => [
        'phone_number' => '420777777777',
        'valid' => true,
        'country' => 'cz',
        'call_prefix' => 420,
        'network_code' => '23003',
        'network_name' => 'Vodafone',
    ],
    420777777777 => [
        'phone_number' => '420777777777',
        'valid' => true,
        'country' => 'cz',
        'call_prefix' => 420,
        'network_code' => '23003',
        'network_name' => 'Vodafone',
    ],
    603777777 => [
        'phone_number' => '420603777777',
        'valid' => true,
        'country' => 'cz',
        'call_prefix' => 420,
        'network_code' => '23002',
        'network_name' => 'T-Mobile',
    ],
    42061110: {
        'phone_number': '42061110',
        'valid': false,
        'country': 'cz',
        'call_prefix': 420,
        'network_code': null,
        'network_name': 'unknown'
    },
]
```
