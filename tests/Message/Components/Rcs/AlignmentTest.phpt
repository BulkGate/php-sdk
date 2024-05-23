<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Components\Rcs\Test;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\Alignment;


/**
 * @testCase
 */
class AlignmentTest extends TestCase
{
	public function testEnum(): void
	{
		Assert::same('left', Alignment::Left->value);
		Assert::same('right', Alignment::Right->value);
		Assert::same('LEFT', Alignment::Left->serialize());
		Assert::same('RIGHT', Alignment::Right->serialize());

		Assert::count(2, Alignment::cases());
	}
}

(new AlignmentTest())->run();
