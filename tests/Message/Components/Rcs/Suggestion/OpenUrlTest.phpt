<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\Rcs\Suggestion\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Marek Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\Suggestion\OpenUrl;

/**
 * @testCase
 */
class OpenUrlTest extends TestCase
{
	public function testAction(): void
	{
		Assert::equal([
			'type' => 'open_url',
			'text' => 'text_button',
			'postback' => 'ok',
			'url' => 'https://www.bulkgate.com/',
		], (new OpenUrl('https://www.bulkgate.com/', 'text_button'))->serialize());

		Assert::equal([
			'type' => 'open_url',
			'text' => 'text_button',
			'postback' => 'postback',
			'url' => 'https://www.bulkgate.com/',
		], (new OpenUrl('https://www.bulkgate.com/', 'text_button', 'postback'))->serialize());
	}
}

(new OpenUrlTest())->run();
