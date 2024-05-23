<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\WhatsApp\Components\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\WhatsApp\Components\BodyType;


/**
 * @testCase
 */
class BodyTypeTest extends TestCase
{
	public function testCurrency(): void
	{
		Assert::same(['type' => 'currency', 'amount' => 5.0, 'currency' => 'currency'], BodyType::Currency->createSettings(type: BodyType::Currency, currency: 'currency', amount: 5)->serialize());
	}


	public function testPrice(): void
	{
		Assert::same(['type' => 'price', 'amount' => 5.0, 'currency' => 'currency'], BodyType::Price->createSettings(type: BodyType::Price, currency: 'currency', amount: 5)->serialize());
	}


	public function testText(): void
	{
		Assert::same(['type' => 'text', 'text' => 'text'], BodyType::Text->createSettings(type: BodyType::Text, text: 'text')->serialize());
	}
}

(new BodyTypeTest())->run();
