## Number checker

Number checker will validate format and an existence of input phone numbers.

```php
$connection = new ConnectionStream("application_id", "application_token");

$number_checker = new NumberChecker($connection);
```

The output is array where keys are phone numbers and values are true or false

```php
[
  "420777777777" => false
]
```
