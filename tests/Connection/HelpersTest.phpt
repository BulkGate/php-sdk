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
    public function testParseContentType(): void
    {
        Assert::same('application/json', Helpers::parseContentType('Content-Type: application/json; charset=utf-8'));
        Assert::same('application/json', Helpers::parseContentType('Content-Type: application/json'));
        Assert::same('application/json', Helpers::parseContentType('content-type: application/json; charset=utf-8'));
        Assert::same('application/json', Helpers::parseContentType('content-type: application/json'));
        Assert::null(Helpers::parseContentType('invalid'));
    }


	public function testParseHttpCode(): void
	{
		Assert::null(Helpers::parseHttpCode(null));
		Assert::null(Helpers::parseHttpCode('Content-Type: application/json; charset=utf-8'));
		Assert::same(200, Helpers::parseHttpCode('HTTP/1.1 200 OK'));
		Assert::same(200, Helpers::parseHttpCode('HTTP/1.1 200'));
		Assert::same(200, Helpers::parseHttpCode('HTTP/2 200 OK'));
		Assert::same(400, Helpers::parseHttpCode('HTTP/2 400 Bad Request'));
	}
}

(new HelpersTest())->run();
