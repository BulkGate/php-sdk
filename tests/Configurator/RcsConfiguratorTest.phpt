<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator\Tests;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Configurator\RcsConfigurator, Sdk\Message\Component\Rcs\Height, Sdk\Message\Component\Rcs\Variant, Sdk\Message\Rcs};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class RcsConfiguratorTest extends TestCase
{
	private Rcs|null $rcs = null;

	public function setUp(): void
	{
		$this->rcs = new Rcs(phone_number: '420608777777', variant: Variant::Text, text: 'text');
	}


	public function testConstruct(): void
	{
		$configurator = new RcsConfigurator(sender: 'BulkGate');

		$configurator->configure($this->rcs);

		Assert::same(['BulkGate', null], [$this->rcs->settings->sender, $this->rcs->settings->timeout]);
	}


	public function testMessage(): void
	{
		$configurator = new RcsConfigurator('TOPefekt');

		$configurator->sender('BulkGate');
		$configurator->expiration(65);

		$configurator->configure($this->rcs);

		Assert::same([
			'BulkGate',
			65,
		], [$this->rcs->settings->sender, $this->rcs->settings->timeout]);
	}


	public function testFile(): void
	{
		$configurator = new RcsConfigurator('TOPefekt');

		$message = new Rcs(phone_number: '420608777777', variant: Variant::File, url: 'url', force_refresh: false);

		$configurator->sender('BulkGate');
		$configurator->expiration(65);

		$configurator->configure($message);

		Assert::same([
			'BulkGate',
			65,
		], [$message->settings->sender, $message->settings->timeout]);
	}


	public function testCard(): void
	{
		$configurator = new RcsConfigurator('TOPefekt');

		$configurator->sender('BulkGate');
		$configurator->expiration(65);

		$message = new Rcs(
			phone_number: '420608777777',
			variant: Variant::Card,
			url: 'url',
			title: 'title',
			description: 'description',
		);

		$configurator->configure($message);

		Assert::same([
			'BulkGate',
			65,
		], [$message->settings->sender, $message->settings->timeout]);
	}


	public function testCarousel(): void
	{
		$configurator = new RcsConfigurator('TOPefekt');

		$configurator->sender('BulkGate');
		$configurator->expiration(65);

		$message = new Rcs(
			phone_number: '420608777777',
			variant: Variant::Carousel,
		);

		$configurator->configure($message);

		Assert::same([
			'BulkGate',
			65,
		], [$message->settings->sender, $message->settings->timeout]);
	}


	public function testChannel(): void
	{
		$configurator = new RcsConfigurator('Sender');

		Assert::same('rcs', $configurator->getChannel());
	}
}

(new RcsConfiguratorTest())->run();
