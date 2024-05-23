<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Tests;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Message\Component\WhatsApp\Variant, Sdk\Message\Settings\WhatsApp as WhatsAppSettings, Sdk\Message\WhatsApp};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class WhatsAppTest extends TestCase
{
	public function testSimple(): void
	{
		$whatsapp = new WhatsApp('420777777777', Variant::Text, text: 'test');

		Assert::type(WhatsAppSettings::class, $whatsapp->settings);

		Assert::same('test', $whatsapp->settings->text);


		Assert::same(['whatsapp'], $whatsapp->getChannels());

		Assert::same('preparation', $whatsapp->status);
		Assert::null($whatsapp->message_id);
		Assert::null($whatsapp->part_id);
		Assert::null($whatsapp->error);

		$whatsapp->updateStatus('scheduled', 'id', ['id']);

		Assert::same('scheduled', $whatsapp->status);
		Assert::same('id', $whatsapp->message_id);
		Assert::same(['id'], $whatsapp->part_id);
		Assert::null($whatsapp->error);

		$whatsapp->updateStatus('error', null, null, 'error_message');

		Assert::same('error', $whatsapp->status);
		Assert::null($whatsapp->message_id);
		Assert::null($whatsapp->part_id);
		Assert::same('error_message', $whatsapp->error);

		Assert::same('420777777777', (string) $whatsapp);
	}
}

(new WhatsAppTest())->run();
