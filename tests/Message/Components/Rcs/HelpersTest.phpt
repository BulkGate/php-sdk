<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Components\Rcs\Test;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\Helpers;
use function str_repeat;

/**
 * @testCase
 */
class HelpersTest extends TestCase
{
	public function testEnum(): void
	{
		Assert::same('single',  Helpers::detectBasic(str_repeat('a', 1000)));
		Assert::same('single', Helpers::detectBasic(str_repeat('a', 161)));
		Assert::same('basic', Helpers::detectBasic(str_repeat('a', 160)));
		Assert::same('basic', Helpers::detectBasic(str_repeat('a', 159)));
		Assert::same('basic', Helpers::detectBasic(str_repeat('a', 1)));
	}
}

(new HelpersTest())->run();
