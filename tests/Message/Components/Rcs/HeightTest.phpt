<?php declare(strict_types=1);

namespace BulkGate\Sdk\Message\Components\Rcs\Test;

require __DIR__ . '/../../../bootstrap.php';


/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\Height;

/**
 * @testCase
 */
class HeightTest extends TestCase
{
	public function testEnum(): void
	{
		Assert::same('short', Height::Short->value);
		Assert::same('SHORT', Height::Short->serialize());
		Assert::same('medium', Height::Medium->value);
		Assert::same('MEDIUM', Height::Medium->serialize());
		Assert::same('tall', Height::Tall->value);
		Assert::same('TALL', Height::Tall->serialize());

		Assert::count(3, Height::cases());

		Assert::same(Height::Tall, Height::smartHeightDetect(null, 5, 10, 0));
		Assert::same(Height::Tall, Height::smartHeightDetect(null, 0, 0, 0));

		Assert::same(Height::Medium, Height::smartHeightDetect(null, 5, 10, 1));
		Assert::same(Height::Medium, Height::smartHeightDetect(null, 5, 45, 0));

		Assert::same(Height::Short, Height::smartHeightDetect(null, 10, 45, 0));
		Assert::same(Height::Short, Height::smartHeightDetect(null, 5, 10, 4));

		Assert::same(Height::Short, Height::smartHeightDetect(Height::Short, 5, 10, 4));
		Assert::same(Height::Medium, Height::smartHeightDetect(Height::Medium, 5, 10, 4));
		Assert::same(Height::Tall, Height::smartHeightDetect(Height::Tall, 5, 10, 4));

		Assert::same(Height::Short, Height::smartHeightDetect('short', 5, 10, 4));
		Assert::same(Height::Medium, Height::smartHeightDetect('medium', 5, 10, 4));
		Assert::same(Height::Tall, Height::smartHeightDetect('tall', 5, 10, 4));

		Assert::same(Height::Short, Height::smartHeightDetect('invalid', 5, 10, 4));
		Assert::same(Height::Medium, Height::smartHeightDetect('invalid', 5, 10, 1));
	}
}

(new HeightTest())->run();
