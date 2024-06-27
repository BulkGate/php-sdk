<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator\Tests;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Configurator\WhatsAppConfigurator, Sdk\Message\Component\WhatsApp\Components\BodyText, Sdk\Message\Component\WhatsApp\Components\BodyType, Sdk\Message\Component\WhatsApp\Components\HeaderText, Sdk\Message\Component\WhatsApp\Components\HeaderType,
	Sdk\Message\Component\WhatsApp\Variant, Sdk\Message\WhatsApp
};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class WhatsAppConfiguratorTest extends TestCase
{
	private WhatsApp|null $whatsapp = null;

	public function setUp(): void
	{
		$this->whatsapp = new WhatsApp(phone_number: '420608777777', variant: Variant::Text);
	}


	public function testConstruct(): void
	{
		$configurator = new WhatsAppConfigurator(sender: 'BulkGate');

		$configurator->configure($this->whatsapp);

		Assert::same(['BulkGate', null], [$this->whatsapp->settings->sender, $this->whatsapp->settings->timeout]);
	}


	public function testMessage(): void
	{
		$configurator = new WhatsAppConfigurator('BulkGate');

		$configurator->sender('TOPefekt');
		$configurator->expiration(65);

		$configurator->configure($this->whatsapp);

		Assert::same([
			'TOPefekt',
			65,
		], [$this->whatsapp->settings->sender, $this->whatsapp->settings->timeout]);
	}


	public function testOtp(): void
	{
		$configurator = new WhatsAppConfigurator('BulkGate');

		$message = new WhatsApp(phone_number: '420608777777', variant: Variant::Otp);

		$configurator->sender('TOPefekt');
		$configurator->expiration(65);

		$configurator->configure($message);

		Assert::same([
			'TOPefekt',
			65,
		], [$message->settings->sender, $message->settings->timeout]);
	}


	public function testFile(): void
	{
		$configurator = new WhatsAppConfigurator('BulkGate');

		$message = new WhatsApp(phone_number: '420608777777', variant: Variant::File);

		$configurator->sender('TOPefekt');
		$configurator->expiration(65);

		$configurator->configure($message);

		Assert::same([
			'TOPefekt',
			65,
		], [$message->settings->sender, $message->settings->timeout]);
	}


	public function testLocation(): void
	{
		$configurator = new WhatsAppConfigurator('BulkGate');

		$message = new WhatsApp(phone_number: '420608777777', variant: Variant::Location, latitude: 50.0, longitude: 40.0);

		$configurator->sender('TOPefekt');
		$configurator->expiration(65);

		$configurator->configure($message);

		Assert::same([
			'TOPefekt',
			65,
		], [$message->settings->sender, $message->settings->timeout]);
	}


	public function testTemplate(): void
	{
		$configurator = new WhatsAppConfigurator('BulkGate');

		$message = new WhatsApp(
			phone_number: '420608777777',
			variant: Variant::Template,
			header: new HeaderText(type: HeaderType::Text, text: 'text'),
			body: new BodyText(type: BodyType::Text, text: 'text')
		);

		$configurator->sender('TOPefekt');
		$configurator->expiration(65);

		$configurator->configure($message);

		Assert::same([
			'TOPefekt',
			65,
		], [$message->settings->sender, $message->settings->timeout]);
	}


	public function testChannel(): void
	{
		$configurator = new WhatsAppConfigurator('Sender');

		Assert::same('whatsapp', $configurator->getChannel());
	}
}

(new WhatsAppConfiguratorTest())->run();
