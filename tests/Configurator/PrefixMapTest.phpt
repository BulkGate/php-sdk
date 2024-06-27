<?php declare(strict_types=1);

namespace BulkGate\Sdk\Configurator\Tests;

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Configurator\PrefixMap;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class PrefixMapTest extends TestCase
{
	public function testConstants(): void
	{
		Assert::same('us', PrefixMap::PrefixToIso['1']);
		Assert::same('cz', PrefixMap::PrefixToIso['420']);
		Assert::same('ru', PrefixMap::PrefixToIso['7']);
	}
}

(new PrefixMapTest())->run();
