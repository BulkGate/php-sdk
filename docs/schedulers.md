Schedulers
==========

Schedulers are classes that allow scheduling messages at certain intervals or in particular times.

## Simple scheduler

Simple scheduler for sending messages at particular time.

```php
$scheduler = new Simple(new DateTime('2025-12-13 12:00'));

$scheduler->schedule($message);
```

## Campaign

Campaign scheduler allows you to start sending messages from particular time by at defined intervals. You can also define how many planned messages will be sent out after certain interval.

```php
$scheduler = new Campaign(new DateTime('2025-12-13 12:00'));

$scheduler->restriction(100 /* messages */, 2, 'hours');

$scheduler->schedule($message);
```
