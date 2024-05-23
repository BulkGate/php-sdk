<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\Rcs\Suggestion\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\Suggestion\DialNumber;

/**
 * @testCase
 */
class DialNumberTest extends TestCase
{
	public function testAction(): void
	{
		Assert::equal([
			'type' => 'dial_number',
			'text' => 'text_button',
			'postback' => 'ok',
			'phoneNumber' => '+420777777777',
		], (new DialNumber('+420777777777', 'text_button'))->serialize());

		Assert::equal([
			'type' => 'dial_number',
			'text' => 'text_button',
			'postback' => 'postback',
			'phoneNumber' => '+420777777777',
		], (new DialNumber('420-777-(777)-777', 'text_button', 'postback'))->serialize());
	}
}

(new DialNumberTest())->run();
