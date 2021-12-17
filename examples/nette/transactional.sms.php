<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Message\Sms, Sender};

require_once __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/DIContainerFactory.php';

/** @var Sender $sender */
$sender = DIContainerFactory::create(__DIR__ . '/sdk.neon')->getByType(Sender::class);

$sms = new Sms('420777777777', 'test message');


try
{
    dump($sender->send($sms));

    /** @dump
    BulkGate\Sdk\Message\Sms #123
        settings: BulkGate\Sdk\Message\Settings\Sms #80
        |  text: BulkGate\Sdk\Message\Component\SimpleText #81
        |  |  text: 'test message'
        |  |  variables: array (0)
        |  sender_id: 'gText'
        |  sender_id_value: 'Example'
        |  unicode: true
        phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #79
        |  phone_number: '420777777777'
        |  iso: 'cz'
        schedule: null
        status: 'accepted'
        message_id: 'sms-xxxxxxxxxx'
        part_id: array (1)
        |  0 => 'sms-xxxxxxxxxx'
        error: null
     */
}
catch (Throwable $e)
{
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
