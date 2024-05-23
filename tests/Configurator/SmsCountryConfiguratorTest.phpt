<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\{Sdk\Message\Sms, Sdk\Configurator\SmsCountryConfigurator};

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class SmsCountryConfiguratorTest extends TestCase
{
	private Sms|null $sms = null;

	public function setUp()
	{
		$this->sms = new Sms('420608777777', 'test');
	}


	public function testConstruct(): void
	{
		$configurator = new SmsCountryConfigurator(true);

		$configurator->configure($this->sms);

		Assert::same(['gGate1', '', true], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value, $this->sms->settings->unicode]);
	}


	public function testAdd(): void
	{
		$configurator = new SmsCountryConfigurator();

		$configurator
			->addCountry('cz', 'gGate2', 'BulkGate')
			->addCountry('sk', 'gGate4', 'TOPefekt');

		$configurator->configure($this->sms);

		Assert::same(['gGate2', 'BulkGate', false], [$this->sms->settings->sender_id, $this->sms->settings->sender_id_value, $this->sms->settings->unicode]);

		$sk_message = new Sms('421777777777', 'test');

		$configurator->configure($sk_message);

		Assert::same(['gGate4', 'TOPefekt', false], [$sk_message->settings->sender_id, $sk_message->settings->sender_id_value, $sk_message->settings->unicode]);

		$configurator->removeCountry('sk');

		$configurator->unicode(true);

		$configurator->configure($sk_message);

		// Restrict rewrite test
		Assert::same(['gGate4', 'TOPefekt', false], [$sk_message->settings->sender_id, $sk_message->settings->sender_id_value, $sk_message->settings->unicode]);

		$second_message = new Sms('421777777777', 'test');

		$configurator->configure($second_message);

		Assert::same(['gGate1', '', true], [$second_message->settings->sender_id, $second_message->settings->sender_id_value, $second_message->settings->unicode]);
	}


	public function testChannel(): void
	{
		$configurator = new SmsCountryConfigurator();

		Assert::same('sms', $configurator->getChannel());
	}
}

(new SmsCountryConfiguratorTest())->run();
