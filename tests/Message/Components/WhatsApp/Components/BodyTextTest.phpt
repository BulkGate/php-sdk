<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\WhatsApp\Components\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\WhatsApp\Components\{BodyText, BodyType};


/**
 * @testCase
 */
class BodyTextTest extends TestCase
{
	public function testBase(): void
	{
		Assert::same([
			'type' => BodyType::Text->value,
			'text' => 'test'
		], (new BodyText(type: BodyType::Text, text: 'test'))->serialize());
	}
}

(new BodyTextTest())->run();
