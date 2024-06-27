<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection\Test;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\{Connection\ConnectionStream, Connection\Request, Message\Api, ConnectionException, Connection\MockCallCounter};

require __DIR__ . '/../bootstrap.php';
require __DIR__ . '/FileFunctionsMock.php';

/**
 * @testCase
 */
class ConnectionStreamTest extends TestCase
{
	public function setUp(): void
	{
		MockCallCounter::reset();
	}


	public function testSuccess(): void
	{
		$connection = new ConnectionStream(1234, 'token', 'api://sdk', 'nette');

		$connection->send(new Request('success', new Api(['test' => true])));

		Assert::same([
			'stream_context_create' => [
				[
					[
						[
							'http' => [
								'method' => 'POST',
								'header' => ['Content-type: application/json'],
								'content' => '{"application_id":1234,"application_token":"token","application_product":"nette","test":true}',
								'ignore_errors' => true,
							],
						],
					],
				],
			],
			'fopen' => [[['api://sdk/success', 'r', false, true]]],
			'stream_get_contents' => [[['success']]],
			'stream_get_meta_data' => [[['success']]],
			'fclose' => [[['success']]],
		], MockCallCounter::$callstack);
	}


	public function testFail(): void
	{
		$connection = new ConnectionStream(1234, 'token', 'api://sdk', 'nette');

		Assert::exception(fn() => $connection->send(new Request('fail', new Api(['test' => true]))), ConnectionException::class, 'BulkGate server is unavailable - api://sdk/fail');

		Assert::same([
			'stream_context_create' => [
				[
					[
						[
							'http' => [
								'method' => 'POST',
								'header' => ['Content-type: application/json'],
								'content' => '{"application_id":1234,"application_token":"token","application_product":"nette","test":true}',
								'ignore_errors' => true,
							],
						],
					],
				],
			],
			'fopen' => [[['api://sdk/fail', 'r', false, true]]],
		], MockCallCounter::$callstack);
	}


	public function testInvalid(): void
	{
		$connection = new ConnectionStream(1234, 'token', 'api://sdk', 'nette');

		Assert::exception(fn() => $connection->send(new Request('invalid', new Api(['test' => true]))), ConnectionException::class, 'BulkGate server is unavailable - api://sdk/invalid');

		Assert::same([
			'stream_context_create' => [
				[
					[
						[
							'http' => [
								'method' => 'POST',
								'header' => ['Content-type: application/json'],
								'content' => '{"application_id":1234,"application_token":"token","application_product":"nette","test":true}',
								'ignore_errors' => true,
							],
						],
					],
				],
			],
			'fopen' => [[['api://sdk/invalid', 'r', false, true]]],
			'stream_get_contents' => [[['invalid']]],
			'stream_get_meta_data' => [[['invalid']]],
			'fclose' => [[['invalid']]],
		], MockCallCounter::$callstack);
	}
}

(new ConnectionStreamTest())->run();
