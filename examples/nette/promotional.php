<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\{Sdk\Message\Bulk, Sdk\Message\Component\Button, Sdk\Message\Component\Image, Sdk\Message\Component\SimpleText, Sdk\Message\MultiChannel, Sdk\Message\Sms, Sdk\Message\Viber, Sdk\Sender};

require_once __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/DIContainerFactory.php';

/** @var Sender $sender */
$sender = \DIContainerFactory::create(__DIR__ . '/sdk.neon')->getByType(Sender::class);



$bulk = new Bulk([
    new Sms('420777777777', 'test message'),
    new Viber('420777777777', 'test message', 'BulkGate' /** @info YOU MUST HAVE REGISTERED VIBER SENDER ID -> Contact us -> support@bulkgate.com */)
]);


$bulk[] = new Viber('420777777777', 'test message');
$bulk[] = new Sms('420777777777', 'test message');


/** @info Primary Viber message with SMS backup */
$bulk[] = (new MultiChannel('420777777777'))
    ->viber(
        new SimpleText('Hello <variable>', ['variable' => 'Lukáš']),
        'BulkGate', /** @info YOU MUST HAVE REGISTERED VIBER SENDER ID -> Contact us -> support@bulkgate.com */
        new Button('Viber', 'https://www.bulkgate.com/'),
        new Image('https://opengraph.githubassets.com/3c7f0395b85f435b40c3215187c75df5fdc201b3f34917cb57fdc2019304af69/BulkGate/php-sdk')
    )
    ->sms(new SimpleText('backup text'), 'gText', 'BulkGate');


try
{
    dump($sender->send($bulk));

    /** @dump
    BulkGate\Sdk\Message\Bulk #123
        list: array (5)
        |  0 => BulkGate\Sdk\Message\Sms #79
        |  |  settings: BulkGate\Sdk\Message\Settings\Sms #81
        |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #93
        |  |  |  |  text: 'test message'
        |  |  |  |  variables: array (0)
        |  |  |  sender_id: 'gText'
        |  |  |  sender_id_value: 'Example'
        |  |  |  unicode: true
        |  |  phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #80
        |  |  |  phone_number: '420777777777'
        |  |  |  iso: 'cz'
        |  |  schedule: null
        |  |  status: 'accepted'
        |  |  message_id: 'idxxxxxxxxxxxxx-0'
        |  |  part_id: array (1)
        |  |  |  0 => 'idxxxxxxxxxxxxx-0'
        |  |  error: null
        |  1 => BulkGate\Sdk\Message\Viber #86
        |  |  phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #82
        |  |  |  phone_number: '420777777777'
        |  |  |  iso: null
        |  |  settings: BulkGate\Sdk\Message\Settings\Viber #87
        |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #83
        |  |  |  |  text: 'test message'
        |  |  |  |  variables: array (0)
        |  |  |  sender: 'BulkGate'
        |  |  |  button: null
        |  |  |  image: null
        |  |  |  timeout: 10800
        |  |  schedule: null
        |  |  status: 'accepted'
        |  |  message_id: 'idxxxxxxxxxxxxx-1'
        |  |  part_id: array (1)
        |  |  |  0 => 'idxxxxxxxxxxxxx-1'
        |  |  error: null
        |  2 => BulkGate\Sdk\Message\Viber #118
        |  |  phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #76
        |  |  |  phone_number: '420777777777'
        |  |  |  iso: null
        |  |  settings: BulkGate\Sdk\Message\Settings\Viber #74
        |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #73
        |  |  |  |  text: 'test message'
        |  |  |  |  variables: array (0)
        |  |  |  sender: null
        |  |  |  button: null
        |  |  |  image: null
        |  |  |  timeout: 10800
        |  |  schedule: null
        |  |  status: 'invalid_sender'
        |  |  message_id: null
        |  |  part_id: null
        |  |  error: 'Invalid sender'
        |  3 => BulkGate\Sdk\Message\Sms #72
        |  |  settings: BulkGate\Sdk\Message\Settings\Sms #70
        |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #69
        |  |  |  |  text: 'test message'
        |  |  |  |  variables: array (0)
        |  |  |  sender_id: 'gText'
        |  |  |  sender_id_value: 'Example'
        |  |  |  unicode: true
        |  |  phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #71
        |  |  |  phone_number: '420777777777'
        |  |  |  iso: 'cz'
        |  |  schedule: null
        |  |  status: 'accepted'
        |  |  message_id: 'idxxxxxxxxxxxxx-3'
        |  |  part_id: array (1)
        |  |  |  0 => 'idxxxxxxxxxxxxx-3'
        |  |  error: null
        |  4 => BulkGate\Sdk\Message\MultiChannel #68
        |  |  primary_channel: 'viber'
        |  |  channels: array (2)
        |  |  |  'viber' => BulkGate\Sdk\Message\Settings\Viber #63
        |  |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #66
        |  |  |  |  |  text: 'Hello <variable>'
        |  |  |  |  |  variables: array (1)
        |  |  |  |  |  |  'variable' => 'Lukáš'
        |  |  |  |  sender: 'BulkGate'
        |  |  |  |  button: BulkGate\Sdk\Message\Component\Button #65
        |  |  |  |  |  caption: 'Viber'
        |  |  |  |  |  url: 'https://www.bulkgate.com/'
        |  |  |  |  image: BulkGate\Sdk\Message\Component\Image #64
        |  |  |  |  |  url: 'https://opengraph.githubassets.com/3c7f0395b85f435b40c3215187c75df5fdc201b3f34917cb57fdc2019304af69/BulkGate/php-sdk'
        |  |  |  |  |  zoom: false
        |  |  |  |  timeout: 10800
        |  |  |  'sms' => BulkGate\Sdk\Message\Settings\Sms #61
        |  |  |  |  text: BulkGate\Sdk\Message\Component\SimpleText #62
        |  |  |  |  |  text: 'backup text'
        |  |  |  |  |  variables: array (0)
        |  |  |  |  sender_id: 'gText'
        |  |  |  |  sender_id_value: 'Example'
        |  |  |  |  unicode: true
        |  |  phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #67
        |  |  |  phone_number: '420777777777'
        |  |  |  iso: 'cz'
        |  |  schedule: null
        |  |  status: 'accepted'
        |  |  message_id: 'idxxxxxxxxxxxxx-4'
        |  |  part_id: array (1)
        |  |  |  0 => 'idxxxxxxxxxxxxx-4'
        |  |  error: null
    */
}
catch (Throwable $e)
{
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
