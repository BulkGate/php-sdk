<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\{Message\Component\Viber\Variant, Message\Viber, Sender};

require_once __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/DIContainerFactory.php';

/** @var Sender $sender */
$sender = DIContainerFactory::create(__DIR__ . '/sdk.neon')->getByType(Sender::class);

$viber = new Viber(
	phone_number: '+420777777777',
	text: 'test message', /** @info YOU MUST HAVE REGISTERED VIBER SENDER ID -> Contact us -> support@bulkgate.com */
	variables: ["first_name" => "name"],
	variant: Variant::Text,
	sender: 'BulkGate',
);


try
{

	$sender->addSenderConfigurator(new BulkGate\Sdk\Configurator\ViberConfigurator(sender: 'BulkGate'));
	dump($sender->send($viber));

	/** @dump
	 * BulkGate\Sdk\Message\Viber #123
	 * phone_number: BulkGate\Sdk\Message\Component\PhoneNumber #79
	 * |  phone_number: '420777777777'
	 * |  iso: null
	 * settings: BulkGate\Sdk\Message\Settings\Viber #80
	 * |  text: BulkGate\Sdk\Message\Component\SimpleText #81
	 * |  |  text: 'test message'
	 * |  |  variables: array (0)
	 * |  sender: 'BulkGate'
	 * |  button: null
	 * |  image: null
	 * |  timeout: 10800
	 * schedule: null
	 * status: 'accepted'
	 * message_id: 'viber-xxxxxxxxxx'
	 * part_id: array (1)
	 * |  0 => 'viber-xxxxxxxxxx'
	 * error: null
	 */
}
catch (Throwable $e)
{
	echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
