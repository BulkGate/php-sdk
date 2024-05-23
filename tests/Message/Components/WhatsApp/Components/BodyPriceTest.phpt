<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\WhatsApp\Components\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\WhatsApp\Components\{BodyType, BodyPrice};


/**
 * @testCase
 */
class BodyPriceTest extends TestCase
{
	public function testBase(): void
	{
		Assert::same(['type' => BodyType::Price->value, 'amount' => 5.0, 'currency' => 'currency'], (new BodyPrice(type: BodyType::Price, amount: 5, currency: 'currency'))->serialize());
	}
}

(new BodyPriceTest())->run();
