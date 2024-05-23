<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Components\Rcs\Test;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\Orientation;

/**
 * @testCase
 */
class OrientationTest extends TestCase
{
	public function testEnum(): void
	{
		Assert::same('vertical', Orientation::Vertical->value);
		Assert::same('VERTICAL', Orientation::Vertical->serialize());
		Assert::same('horizontal', Orientation::Horizontal->value);
		Assert::same('HORIZONTAL', Orientation::Horizontal->serialize());

		Assert::count(2, Orientation::cases());

		Assert::same(Orientation::Vertical, Orientation::smartOrientationDetect(null, 0, 0, 4));

		Assert::same(Orientation::Vertical, Orientation::smartOrientationDetect(null, 0, 0, 0));

		Assert::same(Orientation::Vertical, Orientation::smartOrientationDetect(Orientation::Vertical, 0, 0, 4));
		Assert::same(Orientation::Horizontal, Orientation::smartOrientationDetect(Orientation::Horizontal, 0, 0, 4));

		Assert::same(Orientation::Vertical, Orientation::smartOrientationDetect('invalid', 10, 10, 0));
		Assert::same(Orientation::Vertical, Orientation::smartOrientationDetect('vertical', 10, 10, 0));
		Assert::same(Orientation::Horizontal, Orientation::smartOrientationDetect('horizontal', 10, 10, 0));
	}
}

(new OrientationTest())->run();
