<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Configurator\ViberConfigurator, Sdk\Message\Component\Button, Sdk\Message\Component\Image, Sdk\Message\Component\Viber\Variant, Sdk\Message\Viber};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class ViberConfiguratorTest extends TestCase
{
	private Viber|null $viber = null;

	public function setUp(): void
	{
		$this->viber = new Viber('420608777777', 'test');
	}


	public function testConstruct(): void
	{
		$configurator = new ViberConfigurator('BulkGate');

		$configurator->configure($this->viber);

		Assert::same(
			['BulkGate', null],
			[
				$this->viber->settings->sender,
				$this->viber->settings->timeout
			]
		);
	}


	public function testViberCard(): void
	{
		$viber = new Viber(phone_number: '420608777777', text: 'test', variant: Variant::Card);

		$configurator = new ViberConfigurator('BulkGate');

		$configurator->configure($viber);

		Assert::same(
			['BulkGate', null, null, null],
			[
				$viber->settings->sender,
				$viber->settings->button,
				$viber->settings->image,
				$viber->settings->timeout
			]);
	}


	public function testSimple(): void
	{
		$viber = new Viber(phone_number: '420608777777', text: 'test', variant: Variant::Card, button: new Button(caption: 'buy it old', url: 'url_button_old'), image: new Image(url: 'url', zoom: true));

		$configurator = new ViberConfigurator('TOPefekt');

		$configurator->image('url', true);

		$configurator->button('buy it', 'url_button');

		$configurator->expiration(500);

		$configurator->configure($viber);

		Assert::same([
			'TOPefekt',
			['caption' => 'buy it old', 'url' => 'url_button_old'],
			['url' => 'url', 'zoom' => true],
			500,
		], [$viber->settings->sender, (array)$viber->settings->button, (array)$viber->settings->image, $viber->settings->timeout]);
	}


	public function testChannel(): void
	{
		$configurator = new ViberConfigurator('Sender');

		Assert::same('viber', $configurator->getChannel());
	}
}

(new ViberConfiguratorTest())->run();
