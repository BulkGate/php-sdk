<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\Rcs\Test;

require __DIR__ . '/../../../bootstrap.php';

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\Variant;
use BulkGate\Sdk\Message\Settings\{RcsText, RcsFile, RcsCard, RcsCarousel};


/**
 * @testCase
 */
class VariantTest extends TestCase
{
	public function testEnum(): void
	{
		Assert::type(RcsText::class, Variant::Text->createSettings(text: 'text'));
		Assert::type(RcsFile::class, Variant::File->createSettings(url: 'url', force_refresh: false));
		Assert::type(RcsCard::class, Variant::Card->createSettings(title: 'title', description: 'description', url: 'url'));
		Assert::type(RcsCarousel::class, Variant::Carousel->createSettings());

		Assert::count(5, Variant::cases());
	}
}

(new VariantTest())->run();
