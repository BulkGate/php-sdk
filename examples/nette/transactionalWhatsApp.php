<?php declare(strict_types=1);

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Sdk\Scheduler\Simple;
use BulkGate\Sdk\Sender;
use BulkGate\Sdk\Configurator\WhatsAppConfigurator;
use BulkGate\Sdk\Message\{Component\WhatsApp\Variant, WhatsApp};

require_once __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/DIContainerFactory.php';

/** @var Sender $sender */
$sender = DIContainerFactory::create(__DIR__ . '/sdk.neon')->getByType(Sender::class);


$viber = new WhatsApp(
	phone_number: '+420777777777',
	variant: Variant::Text,
	text: 'text',
	preview_url: true,
	sender: 'BulkGate',
	timeout: 60,
);


try
{
	$scheduler = new Simple(new DateTime('2022-05-14 20:00:00'));
	$sender->setScheduler($scheduler);
	$sender->addSenderConfigurator(new WhatsAppConfigurator(sender: 'BulkGate'));
	dump($sender->send($viber));
}
catch (Throwable $e)
{
	echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
