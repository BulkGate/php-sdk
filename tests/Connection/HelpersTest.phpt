<?php declare(strict_types=1);

namespace BulkGate\Sdk\Connection\Tests;

/**
 * @author Lukáš Piják 2022 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Connection\Helpers;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class HelpersTest extends TestCase
{
	public function testContentType(): void
	{
		Assert::same('application/json', Helpers::parseContentType('Content-Type: application/json; charset=utf-8'));
		Assert::same('application/json', Helpers::parseContentType('Content-Type: application/json'));
		Assert::same('application/json', Helpers::parseContentType('content-type: application/json; charset=utf-8'));
		Assert::same('application/json', Helpers::parseContentType('content-type: application/json'));
		Assert::null(Helpers::parseContentType('invalid'));
	}
}

(new HelpersTest())->run();
