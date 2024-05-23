<?php declare(strict_types=1);

namespace BulkGate\Model\Messaging\Message\Components\Rcs\Suggestion\Test;

require __DIR__ . '/../../../../bootstrap.php';

/**
 * @author Lukáš Piják 2024 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use Tester\{Assert, TestCase};
use BulkGate\Sdk\Message\Component\Rcs\Suggestion\ShareLocation;

/**
 * @testCase
 */
class ShareLocationTest extends TestCase
{
	public function testAction(): void
	{
		Assert::equal([
			'type' => 'share_location',
			'text' => 'button_text',
			'postback' => 'postback',
		], (new ShareLocation('button_text', 'postback'))->serialize());
	}
}

(new ShareLocationTest())->run();
