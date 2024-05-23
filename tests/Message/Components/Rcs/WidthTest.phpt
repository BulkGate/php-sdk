<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Components\Rcs\Test;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\Width;

/**
 * @testCase
 */
class WidthTest extends TestCase
{
	public function testEnum(): void
	{
		Assert::same('small', Width::Small->value);
		Assert::same('SMALL', Width::Small->serialize());
		Assert::same('medium', Width::Medium->value);
		Assert::same('MEDIUM', Width::Medium->serialize());

		Assert::count(2, Width::cases());
	}
}

(new WidthTest())->run();
