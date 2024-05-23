<?php declare(strict_types=1);

namespace BulkGate\Sdk\Tests;

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Mockery;
use Nette\Utils\ArrayHash;
use Nette\Schema\Processor;
use Tester\{Assert, TestCase};
use BulkGate\Sdk\{DI\Extension, Message\Component\SmsSender};
use Nette\DI\{ContainerBuilder, Definitions\ServiceDefinition};

require __DIR__ . '/bootstrap.php';

/**
 * @testCase
 */
class ExtensionTest extends TestCase
{
	private const Config = [
		'application_id' => 1,
		'application_token' => '',
		'application_product' => '',
		'connection' => [
			'api' => 'http://localhost/bulkgate/api/1.0/integration',
			'content_type' => 'application/json'
		],
		'sender' => [
			'tag' => '',
			'default_country' => null
		],
		'configurator' => [
			'sms' => [
				'sender_id' => SmsSender::GATE_SYSTEM_NUMBER,
				'sender_id_value' => SmsSender::GATE_SYSTEM_NUMBER,
				'unicode' => false,
				'country' => [
					[
						'gate' => '',
						'sender' => ''
					]
				]
			],
			'viber' => [
				'sender' => '',
				'button' => [
					'caption' => 'OK',
					'url' => ''
				],
				'image' => [
					'url' => '',
					'zoom' => false
				],
				'expiration' => 6000
			]
		]
	];


	public function testGetConfigSchema(): void
	{
		/**
		 * @var Extension $extension
		 */
		$extension = Mockery::mock(Extension::class)->makePartial();

		$schema = $extension->getConfigSchema();

		$processor = new Processor;

		$normalized = $processor->process($schema, self::Config);

		Assert::same(1, $normalized->application_id);
		Assert::same('', $normalized->application_token);
		Assert::same('', $normalized->application_product);
		Assert::same([
			'api' => 'http://localhost/bulkgate/api/1.0/integration',
			'content_type' => 'application/json'
		], (array) $normalized->connection);

		Assert::same(['tag' => '', 'default_country' => null], (array) $normalized->sender);

		Assert::same('gSystem', $normalized->configurator->sms->sender_id);
		Assert::same('gSystem', $normalized->configurator->sms->sender_id_value);
		Assert::same(false, $normalized->configurator->sms->unicode);
		Assert::same([
			'gate' => '',
			'sender' => ''
		], (array) $normalized->configurator->sms->country[0]);

		Assert::same('', $normalized->configurator->viber->sender);
		Assert::same([
			'caption' => 'OK',
			'url' => '',
		], (array) $normalized->configurator->viber->button);
		Assert::same([
			'url' => '',
			'zoom' => false
		], (array) $normalized->configurator->viber->image);

		Assert::same(6000, $normalized->configurator->viber->expiration);

		Mockery::close();
	}


	public function testLoadConfiguration(): void
	{
		$builder = Mockery::mock(ContainerBuilder::class);
		$builder->shouldReceive('addDefinition')->with('test.configurator.sms')->andReturn(new ServiceDefinition());
		$builder->shouldReceive('addDefinition')->with('test.configurator.viber')->andReturn(new ServiceDefinition());
		$builder->shouldReceive('addDefinition')->with('test.connection')->andReturn(new ServiceDefinition());
		$builder->shouldReceive('addDefinition')->with('test.sender')->andReturn(new ServiceDefinition());
		$builder->shouldReceive('addDefinition')->with('test.number.checker')->andReturn(new ServiceDefinition());
		$builder->shouldReceive('addDefinition')->with('test.credit.checker')->andReturn(new ServiceDefinition());

		$extension = Mockery::mock(Extension::class)->makePartial();

		Assert::with($extension, fn () => $this->name = 'test');
		Assert::with($extension, fn () => $this->config = ArrayHash::from([
			'application_id' => 1,
			'application_token' => 'application_token',
			'application_product' => 'application_product',
			'connection' => [
				'api' => 'http://localhost/bulkgate/api/1.0/integration',
				'content_type' => 'application/json'
			],
			'sender' => [
				'tag' => '',
				'default_country' => null
			],
			'configurator' => (object) [
				'sms' => (object) [
					'sender_id' => SmsSender::GATE_SYSTEM_NUMBER,
					'sender_id_value' => SmsSender::GATE_SYSTEM_NUMBER,
					'unicode' => false,
					'country' => [
						(object) [
							'gate' => '',
							'sender' => ''
						]
					]
				],
				'viber' => (object) [
					'sender' => '',
					'button' => (object) [
						'caption' => 'OK',
						'url' => ''
					],
					'image' => (object) [
						'url' => '',
						'zoom' => false
					],
					'expiration' => 6000
				]
			]
		]));

		$extension->shouldReceive('getContainerBuilder')->withNoArgs()->once()->andReturn($builder);

		$extension->loadConfiguration();
	}


	public function testLoadConfigurationCountry(): void
	{
		$builder = Mockery::mock(ContainerBuilder::class);
		$builder->shouldReceive('addDefinition')->with('test.configurator.sms')->andReturn(new ServiceDefinition());
		$builder->shouldReceive('addDefinition')->with('test.configurator.viber')->andReturn(new ServiceDefinition());
		$builder->shouldReceive('addDefinition')->with('test.connection')->andReturn(new ServiceDefinition());
		$builder->shouldReceive('addDefinition')->with('test.sender')->andReturn(new ServiceDefinition());
		$builder->shouldReceive('addDefinition')->with('test.number.checker')->andReturn(new ServiceDefinition());
		$builder->shouldReceive('addDefinition')->with('test.credit.checker')->andReturn(new ServiceDefinition());

		$extension = Mockery::mock(Extension::class)->makePartial();

		Assert::with($extension, fn () => $this->name = 'test');
		Assert::with($extension, fn () => $this->config = ArrayHash::from([
			'application_id' => 1,
			'application_token' => 'application_token',
			'application_product' => 'application_product',
			'connection' => [
				'api' => 'http://localhost/bulkgate/api/1.0/integration',
				'content_type' => 'application/json'
			],
			'sender' => [
				'tag' => '',
				'default_country' => null
			],
			'configurator' => (object) [
				'sms' => (object) [
					'sender_id' => SmsSender::GATE_SYSTEM_NUMBER,
					'sender_id_value' => SmsSender::GATE_SYSTEM_NUMBER,
					'unicode' => false,
					'country' => []
				],
				'viber' => (object) [
					'sender' => '',
					'button' => (object) [
						'caption' => 'OK',
						'url' => ''
					],
					'image' => (object) [
						'url' => '',
						'zoom' => false
					],
					'expiration' => 6000
				]
			]
		]));

		$extension->shouldReceive('getContainerBuilder')->withNoArgs()->once()->andReturn($builder);

		$extension->loadConfiguration();
	}
}

(new ExtensionTest())->run();
