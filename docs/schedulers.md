# Schedulers

Schedulers are classes that allow scheduling messages at certain intervals or in particular times.

## Simple scheduler

Simple scheduler for sending messages at particular time

```php
$scheduler = new Simple(new \DateTime());
$scheduler->schedule($message);
```

## Campaign

Campaign scheduler allows you to start sending messages from particular time by at defined intervals. You can also define how many planned messages will be send out after certain interval.

```php
$scheduler = new Campaign(new \DateTime());
$scheduler->restriction(2, 2, "hours");

$scheduler->schedule($message);
```
